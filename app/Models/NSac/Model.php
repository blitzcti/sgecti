<?php

namespace App\Models\NSac;

use Illuminate\Support\Facades\DB;
use PDOException;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = "";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('database.nsac');
    }

    public function isConnected()
    {
        try {
            DB::connection($this->connection)->getPdo();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
