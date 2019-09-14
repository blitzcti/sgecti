<?php

namespace App\Models\SSO;

use Illuminate\Support\Facades\DB;
use PDOException;

class Model extends \Illuminate\Database\Eloquent\Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('database.sso');
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
