<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DpsScheme extends Model
{
    protected $fillable = [
        'name_bn',
        'name_en',
        'description_bn',
        'description_en',
        'monthly_amount',
        'total_months',
        'profit_rate',
        'status',
    ];

    public function dpsAccounts()
    {
        return $this->hasMany(DpsAccount::class);
    }
}
