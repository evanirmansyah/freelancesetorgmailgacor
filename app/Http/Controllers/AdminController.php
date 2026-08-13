<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class AdminController extends Controller
{
    public function settings()
    {
        $harga_email_khusus      = Setting::where('key', 'harga_email_khusus')->value('value') ?? '';
        $harga_email_bebas       = Setting::where('key', 'harga_email_bebas')->value('value') ?? '';
        $status_email_khusus     = Setting::where('key', 'status_email_khusus')->value('value') ?? 'open';
        $status_email_bebas      = Setting::where('key', 'status_email_bebas')->value('value') ?? 'open';
        $instruksi_email_khusus  = Setting::where('key', 'instruksi_email_khusus')->value('value') ?? '';
        $instruksi_email_bebas   = Setting::where('key', 'instruksi_email_bebas')->value('value') ?? '';
        $notice_banner           = Setting::where('key', 'notice_banner')->value('value') ?? '';

        return view('admin.settings', compact(
            'harga_email_khusus',
            'harga_email_bebas',
            'status_email_khusus',
            'status_email_bebas',
            'instruksi_email_khusus',
            'instruksi_email_bebas',
            'notice_banner'
        ));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'harga_email_khusus'     => 'required|string|max:100',
            'harga_email_bebas'      => 'required|string|max:100',
            'status_email_khusus'    => 'required|in:open,closed',
            'status_email_bebas'     => 'required|in:open,closed',
            'instruksi_email_khusus' => 'nullable|string|max:2000',
            'instruksi_email_bebas'  => 'nullable|string|max:2000',
            'notice_banner'          => 'nullable|string|max:500',
        ]);

        Setting::updateOrCreate(['key' => 'harga_email_khusus'],     ['value' => trim($request->harga_email_khusus)]);
        Setting::updateOrCreate(['key' => 'harga_email_bebas'],      ['value' => trim($request->harga_email_bebas)]);
        Setting::updateOrCreate(['key' => 'status_email_khusus'],    ['value' => $request->status_email_khusus]);
        Setting::updateOrCreate(['key' => 'status_email_bebas'],     ['value' => $request->status_email_bebas]);
        Setting::updateOrCreate(['key' => 'instruksi_email_khusus'], ['value' => trim($request->instruksi_email_khusus ?? '')]);
        Setting::updateOrCreate(['key' => 'instruksi_email_bebas'],  ['value' => trim($request->instruksi_email_bebas ?? '')]);
        Setting::updateOrCreate(['key' => 'notice_banner'],          ['value' => trim($request->notice_banner ?? '')]);

        return back()->with('success', 'Pengaturan job berhasil diperbarui!');
    }
}
