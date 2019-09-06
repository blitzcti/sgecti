<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;

class Active implements Rule
{
    private $model;
    private $except;

    /**
     * Create a new rule instance.
     *
     * @param string $model
     * @param int $except
     */
    public function __construct($model, $except = null)
    {
        $this->model = $model;
        $this->except = $except;
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
        if ($this->except instanceof Collection) {
            $this->except = array_column($this->except->toArray(), "id");
        }

        if (is_array($this->except)) {
            if (in_array($value, $this->except)) {
                return true;
            }
        } else if ($value == $this->except) {
            return true;
        }

        $m = $this->model::find($value);

        return $m->active;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.not_active');
    }
}
