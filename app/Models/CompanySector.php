<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    protected $table = "company_sectors";

    /**
     * primaryKey
     *
     * @var integer
     * @access protected
     */
    protected $primaryKey = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
