<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SetoranEmail;

class SetoranController extends Controller
{
    public function index()
    {
        $setorans = SetoranEmail::with('user')->latest()->get();
        return view('admin.setoran.index', compact('setorans'));
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
