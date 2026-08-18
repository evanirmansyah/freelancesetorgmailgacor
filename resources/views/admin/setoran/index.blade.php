@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Verifikasi Setoran Email</h2>
            <p class="text-slate-500">Kelola setoran tugas email dari user.</p>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
        <a href="{{ route('admin.setoran.index', ['tab' => 'pending']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all
                  {{ $tab === 'pending' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pending
            @if($countPending > 0)
            <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold bg-orange-500 text-white rounded-full">{{ $countPending }}</span>
            @endif
        </a>
        <a href="{{ route('admin.setoran.index', ['tab' => 'dibaca']) }}"
           class="relative flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all
                  {{ $tab === 'dibaca' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Sudah Dibaca
            @if($countDibaca > 0)
            <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold bg-blue-500 text-white rounded-full">{{ $countDibaca }}</span>
            @endif
        </a>
        <a href="{{ route('admin.setoran.index', ['tab' => 'diproses']) }}"
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
                        <th class="px-6 py-4 font-semibold text-slate-700">Kategori</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Jumlah</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Reward</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Status</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($setorans as $setoran)
                    <tr class="hover:bg-slate-50" id="row-{{ $setoran->id }}">
                        <td class="px-6 py-4">{{ $setoran->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $setoran->user->name }}</td>
                        <td class="px-6 py-4">{{ $setoran->category }}</td>
                        <td class="px-6 py-4">{{ $setoran->total_emails }}</td>
                        <td class="px-6 py-4 font-medium text-brand-primary">Rp {{ number_format($setoran->total_reward, 0, ',', '.') }}</td>
                        <td class="px-6 py-4" id="status-{{ $setoran->id }}">
                            @if($setoran->status == 'approved')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-success/10 text-status-success">ACC</span>
                            @elseif($setoran->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-warning/10 text-status-warning">Pending</span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-danger/10 text-status-danger">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="viewData({{ $setoran->id }}, `{{ htmlspecialchars($setoran->email_data, ENT_QUOTES) }}`, '{{ $setoran->status }}', {{ $setoran->is_read ? 'true' : 'false' }})" class="px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-xs font-medium transition-colors">Lihat Data</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                            @if($tab === 'pending') Tidak ada setoran pending baru.
                            @elseif($tab === 'dibaca') Tidak ada setoran yang sudah dibaca.
                            @else Belum ada setoran yang diproses.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal View Data -->
<div id="viewModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Detail Setoran</h3>
            <button onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto flex-1">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Data Email & Password</label>
            <div class="relative">
                <textarea id="viewEmailData" rows="10" readonly class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 font-mono text-sm outline-none"></textarea>
                <button onclick="copyData()" class="absolute top-2 right-2 p-1.5 bg-white border border-slate-200 rounded-md text-slate-500 hover:text-brand-primary hover:border-brand-primary transition-colors" title="Copy">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </button>
            </div>
            
            <div id="actionButtons" class="mt-6 flex gap-3 border-t border-slate-100 pt-6">
                <input type="hidden" id="currentSetoranId">
                <button onclick="promptApprove()" id="btnApprove" class="flex-1 py-2.5 bg-status-success text-white font-bold rounded-xl hover:bg-green-600 transition-colors">Terima (ACC)</button>
                <button onclick="promptReject()" id="btnReject" class="flex-1 py-2.5 bg-status-danger text-white font-bold rounded-xl hover:bg-red-600 transition-colors">Tolak</button>
            </div>
            
            <div id="approveForm" class="mt-4 hidden border-t border-slate-100 pt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Total Reward yang Diberikan (Rp)</label>
                <input type="number" id="approveReward" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm mb-3" placeholder="Contoh: 15000" min="0">
                <div class="flex justify-end gap-2">
                    <button onclick="cancelApprove()" class="px-4 py-2 text-slate-600 text-sm font-medium hover:bg-slate-50 rounded-lg">Batal</button>
                    <button onclick="processAction('approve')" id="btnConfirmApprove" class="px-4 py-2 bg-status-success text-white text-sm font-bold rounded-lg hover:bg-green-600">Konfirmasi ACC</button>
                </div>
            </div>
            <div id="rejectForm" class="mt-4 hidden border-t border-slate-100 pt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Alasan Penolakan</label>
                <textarea id="rejectNotes" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm mb-3"></textarea>
                <div class="flex justify-end gap-2">
                    <button onclick="cancelReject()" class="px-4 py-2 text-slate-600 text-sm font-medium hover:bg-slate-50 rounded-lg">Batal</button>
                    <button onclick="processAction('reject')" id="btnConfirmReject" class="px-4 py-2 bg-status-danger text-white text-sm font-bold rounded-lg hover:bg-red-600">Konfirmasi Tolak</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const csrfToken = '{{ csrf_token() }}';

    async function viewData(id, data, status, isRead) {
        document.getElementById('currentSetoranId').value = id;
        document.getElementById('viewEmailData').value = data;
        
        if (status === 'pending') {
            document.getElementById('actionButtons').classList.remove('hidden');
        } else {
            document.getElementById('actionButtons').classList.add('hidden');
        }
        
        document.getElementById('rejectForm').classList.add('hidden');
        document.getElementById('approveForm').classList.add('hidden');
        document.getElementById('viewModal').classList.remove('hidden');

        // Tandai sebagai sudah dibaca jika belum dibaca dan masih pending
        if (status === 'pending' && !isRead) {
            try {
                await fetch(`/admin/setoran/${id}/mark-read`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken }
                });
            } catch(e) { /* silent fail */ }
        }
    }

    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }

    function copyData() {
        const text = document.getElementById('viewEmailData');
        text.select();
        document.execCommand('copy');
        alert('Data dicopy ke clipboard!');
    }

    function promptReject() {
        document.getElementById('actionButtons').classList.add('hidden');
        document.getElementById('rejectForm').classList.remove('hidden');
        document.getElementById('approveForm').classList.add('hidden');
        document.getElementById('rejectNotes').value = '';
    }

    function promptApprove() {
        document.getElementById('actionButtons').classList.add('hidden');
        document.getElementById('approveForm').classList.remove('hidden');
        document.getElementById('rejectForm').classList.add('hidden');
        document.getElementById('approveReward').value = '';
    }

    function cancelReject() {
        document.getElementById('rejectForm').classList.add('hidden');
        document.getElementById('actionButtons').classList.remove('hidden');
    }

    function cancelApprove() {
        document.getElementById('approveForm').classList.add('hidden');
        document.getElementById('actionButtons').classList.remove('hidden');
    }

    async function processAction(action) {
        const id = document.getElementById('currentSetoranId').value;
        const notes = document.getElementById('rejectNotes').value;
        const reward = document.getElementById('approveReward').value;
        const btnApprove = document.getElementById('btnConfirmApprove');
        const btnReject = document.getElementById('btnConfirmReject');
        
        let url = '';
        let bodyData = new FormData();
        bodyData.append('_token', csrfToken);

        if (action === 'approve') {
            if (!reward) { alert('Silakan masukkan total reward.'); return; }
            url = `/admin/setoran/${id}/approve`;
            bodyData.append('total_reward', reward);
            btnApprove.innerText = 'Memproses...';
            btnApprove.disabled = true;
        } else {
            url = `/admin/setoran/${id}/reject`;
            bodyData.append('admin_notes', notes);
            btnReject.innerText = 'Memproses...';
            btnReject.disabled = true;
        }

        try {
            const response = await fetch(url, {
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
                if (action === 'approve') { btnApprove.innerText = 'Konfirmasi ACC'; btnApprove.disabled = false; }
                else { btnReject.innerText = 'Konfirmasi Tolak'; btnReject.disabled = false; }
            }
        } catch (e) {
            alert('Kesalahan jaringan');
            if (action === 'approve') { btnApprove.innerText = 'Konfirmasi ACC'; btnApprove.disabled = false; }
            else { btnReject.innerText = 'Konfirmasi Tolak'; btnReject.disabled = false; }
        }
    }
</script>
@endsection