<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $connection;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('database.default');
    }
}
