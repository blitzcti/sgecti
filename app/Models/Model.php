<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Facades\DB;
use PDOException;

/**
 * This Model Class is for IDE helper, use it in every Model in the project.
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model
{
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

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
