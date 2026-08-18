@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Verifikasi Penarikan Saldo</h2>
            <p class="text-slate-500">Kelola permintaan penarikan saldo (Withdrawal) dari user.</p>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
        <a href="{{ route('admin.penarikan.index', ['tab' => 'pending']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all
                  {{ $tab === 'pending' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pending
            @if($countPending > 0)
            <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold bg-orange-500 text-white rounded-full">{{ $countPending }}</span>
            @endif
        </a>
        <a href="{{ route('admin.penarikan.index', ['tab' => 'dibaca']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all
                  {{ $tab === 'dibaca' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Sudah Dibaca
            @if($countDibaca > 0)
            <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold bg-blue-500 text-white rounded-full">{{ $countDibaca }}</span>
            @endif
        </a>
        <a href="{{ route('admin.penarikan.index', ['tab' => 'diproses']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all
                  {{ $tab === 'diproses' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Sudah Diproses
            @if($countDiproses > 0)
            <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold bg-slate-400 text-white rounded-full">{{ $countDiproses }}</span>
            @endif
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-slate-700">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">User</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Metode & Akun</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Jumlah</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Status</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($penarikans as $wd)
                    <tr class="hover:bg-slate-50" id="row-{{ $wd->id }}">
                        <td class="px-6 py-4">{{ $wd->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $wd->user->name }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $wd->metode }} {{ $wd->metode === 'Bank' ? '- ' . $wd->nama_bank_ewallet : '' }}</div>
                            <div class="text-xs text-slate-500">{{ $wd->nomor_rekening_hp }} ({{ $wd->nama_pemilik }})</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-brand-primary">Rp {{ number_format($wd->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-4" id="status-{{ $wd->id }}">
                            @if($wd->status == 'approved')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-success/10 text-status-success">Success</span>
                            @elseif($wd->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-warning/10 text-status-warning">Pending</span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-danger/10 text-status-danger">Ditolak (Refund)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($wd->status == 'pending')
                            <div class="flex flex-wrap gap-2">
                                <button onclick="processApprove({{ $wd->id }})" class="px-3 py-1.5 bg-status-success text-white hover:bg-green-600 rounded-lg text-xs font-medium transition-colors">ACC</button>
                                <button onclick="promptReject({{ $wd->id }})" class="px-3 py-1.5 bg-status-danger text-white hover:bg-red-600 rounded-lg text-xs font-medium transition-colors">Tolak</button>
                                @if(!$wd->is_read)
                                <button onclick="markReadPenarikan({{ $wd->id }}, this)" class="px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-xs font-medium transition-colors whitespace-nowrap">
                                    👁 Sudah Dibaca
                                </button>
                                @endif
                            </div>
                            @endif
                            @if($wd->status == 'rejected' && $wd->admin_notes)
                            <div class="text-xs text-slate-500 mt-1">Alasan: {{ $wd->admin_notes }}</div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            @if($tab === 'pending') Tidak ada permintaan penarikan pending baru.
                            @elseif($tab === 'dibaca') Tidak ada permintaan yang sudah dibaca.
                            @else Belum ada permintaan yang diproses.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div id="rejectModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Tolak Penarikan</h3>
            <button onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-4 text-sm text-status-warning bg-status-warning/10 p-3 rounded-lg border border-status-warning/20">
                Menolak penarikan akan otomatis mengembalikan (refund) saldo ke akun user.
            </div>
            <input type="hidden" id="rejectId">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Alasan Penolakan</label>
            <textarea id="rejectNotes" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm mb-4 outline-none focus:border-brand-primary"></textarea>
            
            <div class="flex justify-end gap-3">
                <button onclick="closeRejectModal()" class="px-4 py-2 text-slate-600 font-medium hover:bg-slate-50 rounded-xl">Batal</button>
                <button onclick="submitReject()" id="btnSubmitReject" class="px-4 py-2 bg-status-danger text-white font-bold rounded-xl hover:bg-red-600">Konfirmasi Tolak</button>
            </div>
        </div>
    </div>
</div>

<script>
    const csrfToken = '{{ csrf_token() }}';

    async function markReadPenarikan(id, btn) {
        btn.disabled = true;
        btn.innerText = '...';
        try {
            const res = await fetch(`/admin/penarikan/${id}/mark-read`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.ok) {
                btn.closest('div').removeChild(btn);
            } else {
                btn.disabled = false;
                btn.innerText = '👁 Sudah Dibaca';
            }
        } catch(e) {
            btn.disabled = false;
            btn.innerText = '👁 Sudah Dibaca';
        }
    }

    async function processApprove(id) {
        if(!confirm('Anda yakin ingin menyetujui penarikan ini? Pastikan Anda sudah mentransfer dananya.')) return;

        let bodyData = new FormData();
        bodyData.append('_token', csrfToken);

        try {
            const response = await fetch(`/admin/penarikan/${id}/approve`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: bodyData
            });
            const result = await response.json();
            
            if (response.ok) {
                alert(result.message);
                window.location.reload();
            } else {
                alert(result.message || 'Terjadi kesalahan');
            }
        } catch (e) {
            alert('Kesalahan jaringan');
        }
    }

    function promptReject(id) {
        document.getElementById('rejectId').value = id;
        document.getElementById('rejectNotes').value = '';
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    async function submitReject() {
        const id = document.getElementById('rejectId').value;
        const notes = document.getElementById('rejectNotes').value;
        const btn = document.getElementById('btnSubmitReject');
        
        btn.disabled = true;
        btn.innerText = 'Memproses...';

        let bodyData = new FormData();
        bodyData.append('_token', csrfToken);
        bodyData.append('admin_notes', notes);

        try {
            const response = await fetch(`/admin/penarikan/${id}/reject`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: bodyData
            });
            const result = await response.json();
            
            if (response.ok) {
                alert(result.message);
                window.location.reload();
            } else {
                alert(result.message || 'Terjadi kesalahan');
                btn.disabled = false;
                btn.innerText = 'Konfirmasi Tolak';
            }
        } catch (e) {
            alert('Kesalahan jaringan');
            btn.disabled = false;
            btn.innerText = 'Konfirmasi Tolak';
        }
    }
</script>
@endsection