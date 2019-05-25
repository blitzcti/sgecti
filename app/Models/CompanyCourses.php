<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCourses extends Model
{
    protected $fillable = [
        'company_id', 'course_id',
    ];

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

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
