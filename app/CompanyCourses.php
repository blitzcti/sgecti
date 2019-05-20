<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCourses extends Model
{
    protected $fillable = [
        'id_company', 'id_course',
    ];
}
