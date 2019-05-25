<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BimestralReport extends Model
{
    protected $fillable = [
        'internship_id', 'dia', 'protocolo',
    ];

    public function internship()
    {
        return $this->hasOne(Internship::class);
    }
}
