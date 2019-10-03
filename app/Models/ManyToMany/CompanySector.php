<?php

namespace App\Models\ManyToMany;

class CompanySector extends Model
{
    protected $fillable = [
        'company_id', 'sector_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "company_has_sectors";
}
