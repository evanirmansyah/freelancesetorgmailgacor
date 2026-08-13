<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PenarikanSaldo;
use Illuminate\Support\Facades\DB;

class PenarikanController extends Controller
{
    public function index()
    {
        $penarikans = PenarikanSaldo::with('user')->latest()->get();
        return view('admin.penarikan.index', compact('penarikans'));
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
