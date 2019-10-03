<?php

namespace App\Models\SSO;

abstract class Model extends \App\Models\Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('database.sso');
    }
}
