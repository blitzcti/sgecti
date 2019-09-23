<?php

namespace App\Models\NSac;

abstract class Model extends \App\Models\Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('database.nsac');
    }
}
