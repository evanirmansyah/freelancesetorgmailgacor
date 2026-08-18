@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="mt-2">
        <h3 class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1">RIWAYAT AKTIVITAS</h3>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Mutasi & Saldo</h2>
        <p class="text-xs sm:text-sm text-slate-500">Semua riwayat setoran job email dan penarikan dana kamu.</p>
    </div>

    @if($history->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-10 sm:p-16 flex flex-col items-center justify-center text-center mt-6">
        <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-base font-bold text-slate-700 mb-1">Belum ada riwayat</h3>
        <p class="text-slate-400 text-xs sm:text-sm max-w-xs">Mulai kirim setoran email pada menu Job untuk mendapatkan saldo.</p>
        <a href="{{ route('job') }}" class="mt-4 px-5 py-2 bg-brand-primary text-white text-xs font-bold rounded-xl shadow-xs hover:bg-brand-secondary transition-colors">
            Mulai Kerjakan Job
        </a>
    </div>
    @else
    <!-- History List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden mt-4">
        <div class="overflow-x-auto smooth-scroll">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs">
                    <tr>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700">Tanggal</th>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700">Aktivitas</th>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700">Keterangan</th>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700 text-right">Jumlah</th>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm">
                    @foreach($history as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 sm:px-6 py-3.5 whitespace-nowrap text-slate-500">{{ $item['date']->format('d M Y, H:i') }}</td>
                        <td class="px-4 sm:px-6 py-3.5 font-semibold text-slate-800">
                            <div class="flex items-center gap-2.5">
                                @if($item['type'] === 'job')
                                <div class="w-7 h-7 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                @else
                                <div class="w-7 h-7 rounded-full bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                @endif
                                <span>{{ $item['title'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 sm:px-6 py-3.5 text-slate-500">{{ $item['details'] }}</td>
                        <td class="px-4 sm:px-6 py-3.5 text-right font-bold whitespace-nowrap {{ $item['type'] === 'job' ? 'text-status-success' : 'text-slate-700' }}">
                            {{ $item['type'] === 'job' ? '+' : '-' }} Rp {{ number_format($item['amount'], 0, ',', '.') }}
                        </td>
                        <td class="px-4 sm:px-6 py-3.5 text-center whitespace-nowrap">
                            @if($item['status'] == 'approved')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-status-success/10 text-status-success">
                                Sukses
                            </span>
                            @elseif($item['status'] == 'pending')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-status-warning/10 text-status-warning">
                                Pending
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-status-danger/10 text-status-danger">
                                Ditolak
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
