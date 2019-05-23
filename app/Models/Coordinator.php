<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    protected $fillable = [
        'id_user', 'id_course', 'vigencia_ini', 'vigencia_fim',
    ];

    public function user()
    {
        return User::findOrFail($this->id_user);
    }

    public function course()
    {
        return Course::findOrFail($this->id_course);
    }
}
