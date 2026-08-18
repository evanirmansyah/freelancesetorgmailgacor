<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetoranEmail extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'email_data',
        'total_emails',
        'reward_per_email',
        'total_reward',
        'status',
        'admin_notes',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
