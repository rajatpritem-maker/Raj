<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'type',
        'amount',
        'description_bn',
        'description_en',
        'status',
        'dps_account_id',
        'loan_id',
        'reference',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dpsAccount()
    {
        return $this->belongsTo(DpsAccount::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public static function generateTransactionId()
    {
        $timestamp = time();
        $random = strtoupper(substr(md5($timestamp . rand()), 0, 8));
        return "TRX-{$random}";
    }
}
