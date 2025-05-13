<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class
Task extends Model
{
    protected $fillable = [
        'name',
        'started_at',
        'ended_at',
        'user_id',
        'description',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
