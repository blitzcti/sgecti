<?php

namespace App\Models\ManyToMany;

/*
 * These models are required for backup system. Do not use them in other parts.
 * */

use Illuminate\Support\Facades\DB;
use PDOException;

class Model extends \App\Models\Model
{
    /**
     * primaryKey
     *
     * @var string
     * @access protected
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
