<?php

namespace App\Models\NSac;

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
        return Internship::where('ra', '=', $this->matricula)->get()->first();

        // Laravel bugadasso
        return $this->hasOne(Internship::class, 'ra', 'matricula');
    }
}
