<?php

namespace App\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Unique implements Rule
{
    protected $table;
    protected $column;
    protected $ignore;

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param string $column
     * @param mixed|null $ignore
     */
    public function __construct($table, $column, $ignore = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignore = $ignore;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            if (is_string($value)) {
                $query = DB::table($this->table)->whereRaw("LOWER({$this->column}) = '{$value}'");
            } else {
                $query = DB::table($this->table)->whereRaw("{$this->column} = {$value}");
            }

            if ($this->ignore != null) {
                $query->where('id', '<>', $this->ignore);
            }

            return sizeof($query->get()) == 0;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.unique');
    }
}
