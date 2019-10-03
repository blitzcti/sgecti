<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class FinalReport
 *
 * @package App\Models
 * @property int id
 * @property int internship_id
 * @property int coordinator_id
 * @property Carbon date
 * @property int grade_1_a
 * @property int grade_1_b
 * @property int grade_1_c
 * @property int grade_1_d
 * @property int grade_2_a
 * @property int grade_2_b
 * @property int grade_2_c
 * @property int grade_2_d
 * @property int grade_3_a
 * @property int grade_3_b
 * @property int grade_4_a
 * @property int grade_4_b
 * @property int grade_4_c
 * @property float final_grade
 * @property int completed_hours
 * @property Carbon end_date
 * @property string approval_number
 * @property string observation
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Internship internship
 * @property Coordinator coordinator
 */
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
        'completed_hours' => 'integer',

        'final_grade' => 'float',

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

    public function gradeExplanation($grade)
    {
        if ($grade == 6) {
            return "Excelente";
        } else if ($grade == 5) {
            return "Ótimo";
        } else if ($grade == 4) {
            return "Bom";
        } else if ($grade == 3) {
            return "Médio";
        } else if ($grade == 2) {
            return "Regular";
        } else {
            return "Fraco";
        }
    }

    public function getFinalGradeExplanationAttribute()
    {
        $finalGrade = $this->final_grade;
        if ($finalGrade >= 8.5) {
            return "Excelente";
        } else if ($finalGrade >= 7.2) {
            return "Ótimo";
        } else if ($finalGrade >= 5.8) {
            return "Bom";
        } else if ($finalGrade >= 4.3) {
            return "Médio";
        } else if ($finalGrade >= 2.9) {
            return "Regular";
        } else if ($finalGrade >= 1.4) {
            return "Fraco";
        } else {
            return "Negativo";
        }
    }
}
