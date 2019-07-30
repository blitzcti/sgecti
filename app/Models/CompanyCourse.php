<?php

namespace App\Models;

class CompanyCourse extends Model
{
    protected $fillable = [
        'company_id', 'course_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "company_courses";

    /**
     * primaryKey
     *
     * @var string
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