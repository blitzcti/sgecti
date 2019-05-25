<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'vigencia_ini', 'vigencia_fim',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
