<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = [
        'company_id', 'validade', 'observacao',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
