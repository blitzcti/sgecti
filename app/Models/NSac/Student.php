<?php

namespace App\Models\NSac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDOException;

class Student extends Model
{
    protected $connection = "";

    protected $table = "alunos_view";

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
