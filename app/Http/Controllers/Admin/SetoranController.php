<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SetoranEmail;

class SetoranController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');

        if ($tab === 'diproses') {
            // ACC atau Ditolak
            $setorans = SetoranEmail::with('user')
                ->whereIn('status', ['approved', 'rejected'])
                ->latest()
                ->get();
        } elseif ($tab === 'dibaca') {
            // Pending tapi sudah dibaca admin
            $setorans = SetoranEmail::with('user')
                ->where('status', 'pending')
                ->where('is_read', true)
                ->latest()
                ->get();
        } else {
            // Pending dan belum dibaca (default)
            $setorans = SetoranEmail::with('user')
                ->where('status', 'pending')
                ->where('is_read', false)
                ->latest()
                ->get();
        }

        // Hitung badge tiap tab
        $countPending   = SetoranEmail::where('status', 'pending')->where('is_read', false)->count();
        $countDibaca    = SetoranEmail::where('status', 'pending')->where('is_read', true)->count();
        $countDiproses  = SetoranEmail::whereIn('status', ['approved', 'rejected'])->count();

        return view('admin.setoran.index', compact('setorans', 'tab', 'countPending', 'countDibaca', 'countDiproses'));
    }

    public function markRead($id)
    {
        $setoran = SetoranEmail::findOrFail($id);
        if ($setoran->status === 'pending' && !$setoran->is_read) {
            $setoran->is_read = true;
            $setoran->save();
        }
        return response()->json(['success' => true]);
    }

    public function markUnread($id)
    {
        $setoran = SetoranEmail::findOrFail($id);
        if ($setoran->status === 'pending' && $setoran->is_read) {
            $setoran->is_read = false;
            $setoran->save();
        }
        return response()->json(['success' => true]);
    }

    public function approve(Request $request, $id)
    {
        $request->validate(['total_reward' => 'required|numeric|min:0']);
        $setoran = SetoranEmail::findOrFail($id);
        
        if ($setoran->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status sudah diproses.'], 400);
        }

        $setoran->total_reward = $request->total_reward;

        // Add total reward to user's saldo
        $user = $setoran->user;
        $user->saldo += $setoran->total_reward;
        $user->save();

        // Update status
        $setoran->status = 'approved';
        $setoran->save();

        return response()->json(['success' => true, 'message' => 'Setoran berhasil di-approve dan saldo ditambahkan.']);
    }

    public function reject(Request $request, $id)
    {
        $setoran = SetoranEmail::findOrFail($id);
        
        if ($setoran->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status sudah diproses.'], 400);
        }

        $setoran->status = 'rejected';
        $setoran->admin_notes = $request->admin_notes;
        $setoran->save();

        return response()->json(['success' => true, 'message' => 'Setoran berhasil ditolak.']);
    }
}
