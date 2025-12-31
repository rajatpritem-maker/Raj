<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'title_bn',
        'title_en',
        'content_bn',
        'content_en',
        'priority',
        'status',
        'published_at',
        'admin_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
