<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'started_at',
        'ended_at',
        'user_id',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
