<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $harga_email_khusus = Setting::where('key', 'harga_email_khusus')->value('value') ?? 4300;
        $harga_email_bebas = Setting::where('key', 'harga_email_bebas')->value('value') ?? 3300;

        $user = auth()->user();
        $pending_count = $user->setoranEmails()->where('status', 'pending')->count();
        $approved_count = $user->setoranEmails()->where('status', 'approved')->count();

        return view('dashboard.index', compact('harga_email_khusus', 'harga_email_bebas', 'pending_count', 'approved_count'));
    }

    public function job()
    {
        $harga_email_khusus     = Setting::where('key', 'harga_email_khusus')->value('value') ?? 4300;
        $harga_email_bebas      = Setting::where('key', 'harga_email_bebas')->value('value') ?? 3300;
        $status_email_khusus    = Setting::where('key', 'status_email_khusus')->value('value') ?? 'open';
        $status_email_bebas     = Setting::where('key', 'status_email_bebas')->value('value') ?? 'open';
        $instruksi_email_khusus = Setting::where('key', 'instruksi_email_khusus')->value('value') ?? 'Buat email dengan format tertentu sesuai panduan. Cocok untuk member yang sudah terbiasa. Syarat: Menggunakan IP Indonesia.';
        $instruksi_email_bebas  = Setting::where('key', 'instruksi_email_bebas')->value('value') ?? 'Buat email dengan nama bebas tanpa format khusus. Sangat mudah dan cepat dikerjakan.';
        $notice_banner          = Setting::where('key', 'notice_banner')->value('value') ?? '';

        $history = auth()->user()->setoranEmails()->latest()->take(10)->get();

        return view('dashboard.job', compact(
            'harga_email_khusus',
            'harga_email_bebas',
            'status_email_khusus',
            'status_email_bebas',
            'instruksi_email_khusus',
            'instruksi_email_bebas',
            'notice_banner',
            'history'
        ));
    }

    public function submitJob(Request $request)
    {
        $request->validate([
            'category' => 'required|in:Email Khusus,Email Bebas',
            'email_data' => 'required|string',
        ]);

        // Check if the requested job category is open
        $statusKey = $request->category === 'Email Khusus' ? 'status_email_khusus' : 'status_email_bebas';
        $jobStatus = Setting::where('key', $statusKey)->value('value') ?? 'open';
        if ($jobStatus === 'closed') {
            return response()->json(['success' => false, 'message' => 'Maaf, job ' . $request->category . ' saat ini sedang ditutup. Silakan coba lagi nanti.'], 403);
        }

        $lines = explode("\n", str_replace("\r", "", trim($request->email_data)));
        $validEmails = 0;
        $processedData = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $parts = explode('|', $line);
            if (count($parts) >= 2) {
                $email = trim($parts[0]);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validEmails++;
                    $processedData[] = $line;
                }
            }
        }

        if ($validEmails === 0) {
            return response()->json(['success' => false, 'message' => 'Format email tidak valid. Pastikan formatnya email@gmail.com|password123'], 422);
        }

        auth()->user()->setoranEmails()->create([
            'category' => $request->category,
            'email_data' => implode("\n", $processedData),
            'total_emails' => $validEmails,
            'reward_per_email' => 0,
            'total_reward' => 0,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Email berhasil dikirim! Menunggu verifikasi admin.']);
    }

    public function submitWithdrawal(Request $request)
    {
        $request->validate([
            'metode' => 'required|in:E-Wallet,Bank',
            'nomor_rekening_hp' => 'required|string',
            'nama_pemilik' => 'required|string',
            'jumlah' => 'required|numeric|min:10000',
        ]);

        $nama_bank_ewallet = '';
        if ($request->metode === 'Bank') {
            $nama_bank_ewallet = $request->nama_bank === 'Lainnya' ? $request->nama_bank_lainnya : $request->nama_bank;
        } else {
            $nama_bank_ewallet = $request->nama_ewallet;
        }
        
        if (empty($nama_bank_ewallet)) {
             return response()->json(['success' => false, 'message' => 'Silakan pilih Bank atau E-Wallet yang valid.'], 400);
        }

        $user = auth()->user();

        if ($user->saldo < $request->jumlah) {
            return response()->json(['success' => false, 'message' => 'Saldo tidak mencukupi.'], 400);
        }

        // Deduct saldo
        $user->saldo -= $request->jumlah;
        $user->save();

        // Create pending withdrawal
        $user->penarikanSaldo()->create([
            'metode' => $request->metode,
            'nama_bank_ewallet' => $nama_bank_ewallet,
            'nomor_rekening_hp' => $request->nomor_rekening_hp,
            'nama_pemilik' => $request->nama_pemilik,
            'jumlah' => $request->jumlah,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Permintaan penarikan berhasil diajukan!']);
    }

    public function history()
    {
        $user = auth()->user();
        
        $jobs = $user->setoranEmails()->get()->map(function ($item) {
            return [
                'type' => 'job',
                'title' => 'Setoran ' . $item->category,
                'amount' => $item->total_reward,
                'status' => $item->status,
                'date' => $item->created_at,
                'details' => $item->total_emails . ' Email'
            ];
        });

        $withdrawals = $user->penarikanSaldo()->get()->map(function ($item) {
            return [
                'type' => 'withdrawal',
                'title' => 'Penarikan ke ' . $item->nama_bank_ewallet,
                'amount' => $item->jumlah,
                'status' => $item->status,
                'date' => $item->created_at,
                'details' => $item->nomor_rekening_hp
            ];
        });

        $history = $jobs->concat($withdrawals)->sortByDesc('date');

        return view('dashboard.history', compact('history'));
    }

    public function profile()
    {
        return view('dashboard.profile');
    }
}
