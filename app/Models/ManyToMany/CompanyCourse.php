<?php

namespace App\Models\ManyToMany;

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
    protected $table = "company_has_courses";
}
