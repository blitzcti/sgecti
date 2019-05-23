<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'seg_e', 'seg_s', 'ter_e', 'ter_s', 'qua_e', 'qua_s', 'qui_e', 'qui_s', 'sex_e', 'sex_s', 'sab_e', 'sab_s',
    ];
}
