<?php

namespace App\Models\ManyToMany;

class CompanyHasSector extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'sector_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_has_sectors';
}
