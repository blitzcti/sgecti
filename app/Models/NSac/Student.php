<?php

namespace App\Models\NSac;

use App\Models\Course;
use App\Models\Internship;

class Student extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "alunos_view";

    /**
     * primaryKey
     *
     * @var integer
     * @access protected
     */
    protected $primaryKey = "matricula";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function internship()
    {
        return $this->hasOne(Internship::class, 'ra', 'matricula');
    }

    public function course()
    {
        $this->attributes['course_id'] = substr($this->matricula, 3, 1);
        return $this->belongsTo(Course::class);
    }
}
