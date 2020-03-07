<?php

namespace App\Rules;

use App\Models\Proposal;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class ApprovedProposal implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            $proposal = Proposal::find($value);

            return $proposal->approved_at != null;
        } catch (Throwable $e) {
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
        return __('validation.not_active');
    }
}
