<?php

namespace App\Models\ManyToMany;

class ProposalCourse extends Model
{
    protected $fillable = [
        'proposal_id', 'course_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "proposal_courses";
}
