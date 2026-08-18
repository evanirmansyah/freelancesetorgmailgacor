<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenarikanSaldo extends Model
{
    protected $table = 'penarikan_saldo';
    
    protected $fillable = [
        'user_id',
        'metode',
        'nama_bank_ewallet',
        'nomor_rekening_hp',
        'nama_pemilik',
        'jumlah',
        'status',
        'admin_notes',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
