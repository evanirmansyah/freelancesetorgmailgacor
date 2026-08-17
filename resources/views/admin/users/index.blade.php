@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelola Pengguna</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar semua pengguna yang terdaftar di sistem.</p>
        </div>
        <div>
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email..." class="px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-primary/50 text-sm">
                <button type="submit" class="px-4 py-2 bg-brand-primary text-white rounded-xl text-sm font-medium hover:bg-brand-secondary transition-colors">Cari</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-status-success/10 text-status-success rounded-xl text-sm font-medium border border-status-success/20">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="p-4 bg-status-danger/10 text-status-danger rounded-xl text-sm font-medium border border-status-danger/20">
            {{ session('error') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Pengguna</th>
                        <th class="px-6 py-4 font-semibold">Peran</th>
                        <th class="px-6 py-4 font-semibold">Saldo</th>
                        <th class="px-6 py-4 font-semibold">Terdaftar</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="inline-flex px-2 py-1 rounded-md bg-purple-100 text-purple-700 text-xs font-semibold">Admin</span>
                                @else
                                    <span class="inline-flex px-2 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-semibold">User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-900">
                                Rp {{ number_format($user->saldo, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2" x-data="{ openEdit: false, openDelete: false }">
                                    <!-- Edit Button -->
                                    <button @click="openEdit = true" class="p-2 text-brand-primary hover:bg-brand-primary/10 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <!-- Edit Modal -->
                                    <div x-show="openEdit" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                                        <div @click.away="openEdit = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden text-left">
                                            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                                                <h3 class="text-lg font-bold text-slate-900">Edit Pengguna</h3>
                                                <button @click="openEdit = false" class="text-slate-400 hover:text-slate-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6 space-y-4">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                                                    <input type="text" name="name" value="{{ $user->name }}" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary text-sm">
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                                                    <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary text-sm">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-1">Saldo (Rp)</label>
                                                    <input type="number" name="saldo" value="{{ $user->saldo }}" required min="0" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary text-sm">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-1">Peran (Role)</label>
                                                    <select name="role" required class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary text-sm">
                                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru (Opsional)</label>
                                                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary text-sm">
                                                </div>

                                                <div class="pt-4 flex gap-3">
                                                    <button type="button" @click="openEdit = false" class="flex-1 px-4 py-2 border border-slate-200 text-slate-600 rounded-xl font-medium hover:bg-slate-50 transition-colors">Batal</button>
                                                    <button type="submit" class="flex-1 px-4 py-2 bg-brand-primary text-white rounded-xl font-medium hover:bg-brand-secondary transition-colors">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Delete Button -->
                                    @if($user->id !== auth()->id())
                                    <button @click="openDelete = true" class="p-2 text-status-danger hover:bg-status-danger/10 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div x-show="openDelete" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-center">
                                        <div @click.away="openDelete = false" class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden p-6">
                                            <div class="w-16 h-16 rounded-full bg-status-danger/10 text-status-danger flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-slate-900 mb-2">Hapus Pengguna?</h3>
                                            <p class="text-slate-500 mb-6 text-sm">Anda yakin ingin menghapus akun <b>{{ $user->name }}</b>? Tindakan ini tidak dapat dibatalkan.</p>
                                            
                                            <div class="flex gap-3">
                                                <button @click="openDelete = false" class="flex-1 px-4 py-2 border border-slate-200 text-slate-600 rounded-xl font-medium hover:bg-slate-50 transition-colors">Batal</button>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full px-4 py-2 bg-status-danger text-white rounded-xl font-medium hover:bg-red-600 transition-colors">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <p>Tidak ada data pengguna ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
