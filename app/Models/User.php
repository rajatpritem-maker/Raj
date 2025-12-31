<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'photo',
        'nid_number',
        'nid_image',
        'birth_certificate',
        'address',
        'tracking_code',
        'status',
        'role',
        'is_admin',
        'approved_at',
        'rejected_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->is_admin === 1;
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function dpsAccounts()
    {
        return $this->hasMany(DpsAccount::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public static function generateTrackingCode()
    {
        $year = date('Y');
        $random = strtoupper(substr(md5(time() . rand()), 0, 6));
        return "SMT-{$year}-{$random}";
    }

    public static function generateMemberId()
    {
        $year = substr(date('Y'), -2);
        $count = static::count() + 1;
        return "MEM-{$year}-" . str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}
