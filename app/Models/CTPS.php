<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CTPS extends Model
{
    protected $fillable = [
        'ctps',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ctps';
}
