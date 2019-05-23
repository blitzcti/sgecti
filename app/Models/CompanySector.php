<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySector extends Model
{
    protected $fillable = [
        'id_company', 'id_sector',
    ];

    public function company()
    {
        return Company::findOrFail($this->id_company);
    }
}
