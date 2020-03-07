<?php

namespace App\Models\ManyToMany;

class CompanyHasCourse extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'course_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_has_courses';
}
