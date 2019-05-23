<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCourses extends Model
{
    protected $fillable = [
        'id_company', 'id_course',
    ];

    public function company()
    {
        return Company::findOrFail($this->id_company);
    }
}
