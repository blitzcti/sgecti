<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'name', 'company_id', 'course_id', 'data_limite', 'schedule_id', 'remuneracao', 'descricao', 'observacao',
    ];

    public function company()
    {
        return $this->hasOne(Company::class);
    }
}