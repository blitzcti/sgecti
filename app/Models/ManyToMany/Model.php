<?php

namespace App\Models\ManyToMany;

/*
 * These models are required for backup system. Do not use them in other parts.
 * */

abstract class Model extends \App\Models\Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('database.default');
    }
}
