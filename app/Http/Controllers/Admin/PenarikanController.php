<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PenarikanSaldo;
use Illuminate\Support\Facades\DB;

class PenarikanController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');

        if ($tab === 'diproses') {
            // ACC atau Ditolak
            $penarikans = PenarikanSaldo::with('user')
                ->whereIn('status', ['approved', 'rejected'])
                ->latest()
                ->get();
        } elseif ($tab === 'dibaca') {
            // Pending tapi sudah dibaca admin
            $penarikans = PenarikanSaldo::with('user')
                ->where('status', 'pending')
                ->where('is_read', true)
                ->latest()
                ->get();
        } else {
            // Pending dan belum dibaca (default)
            $penarikans = PenarikanSaldo::with('user')
                ->where('status', 'pending')
                ->where('is_read', false)
                ->latest()
                ->get();
        }

        // Hitung badge tiap tab
        $countPending  = PenarikanSaldo::where('status', 'pending')->where('is_read', false)->count();
        $countDibaca   = PenarikanSaldo::where('status', 'pending')->where('is_read', true)->count();
        $countDiproses = PenarikanSaldo::whereIn('status', ['approved', 'rejected'])->count();

        return view('admin.penarikan.index', compact('penarikans', 'tab', 'countPending', 'countDibaca', 'countDiproses'));
    }

    public function markRead($id)
    {
        $penarikan = PenarikanSaldo::findOrFail($id);
        if ($penarikan->status === 'pending' && !$penarikan->is_read) {
            $penarikan->is_read = true;
            $penarikan->save();
        }
        return response()->json(['success' => true]);
    }

    public function approve(Request $request, $id)
    {
        $penarikan = PenarikanSaldo::findOrFail($id);
        
        if ($penarikan->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status sudah diproses.'], 400);
        }

        $penarikan->status = 'approved';
        $penarikan->save();

        return response()->json(['success' => true, 'message' => 'Penarikan berhasil di-approve (Transfer Selesai).']);
    }

    public function reject(Request $request, $id)
    {
        $penarikan = PenarikanSaldo::findOrFail($id);
        
        if ($penarikan->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status sudah diproses.'], 400);
        }

        DB::transaction(function () use ($penarikan, $request) {
            // Update status
            $penarikan->status = 'rejected';
            $penarikan->admin_notes = $request->admin_notes;
            $penarikan->save();

            // Refund saldo
            $user = $penarikan->user;
            $user->saldo += $penarikan->jumlah;
            $user->save();
        });

        return response()->json(['success' => true, 'message' => 'Penarikan berhasil ditolak dan saldo di-refund.']);
    }
}
