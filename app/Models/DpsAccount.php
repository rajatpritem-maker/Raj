<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DpsAccount extends Model
{
    protected $fillable = [
        'user_id',
        'dps_scheme_id',
        'account_number',
        'total_amount',
        'current_month',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scheme()
    {
        return $this->belongsTo(DpsScheme::class, 'dps_scheme_id');
    }

    public function deposits()
    {
        return $this->hasMany(Transaction::class, 'dps_account_id');
    }
}
