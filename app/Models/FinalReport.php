<?php

namespace App\Models;

class FinalReport extends Model
{
    protected $fillable = [
        'internship_id', 'coordinator_id', 'date', 'grade_1_a', 'grade_1_b', 'grade_1_c', 'grade_1_d', 'grade_2_a',
        'grade_2_b', 'grade_2_c', 'grade_2_d', 'grade_3_a', 'grade_3_b', 'grade_4_a', 'grade_4_b', 'grade_4_c',
        'final_grade', 'completed_hours', 'end_date', 'approval_number', 'observation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'internship_id' => 'integer',
        'coordinator_id' => 'integer',
        'final_grade' => 'float',
        'completed_hours' => 'integer',

        'date' => 'date',
        'end_date' => 'date',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }
}
