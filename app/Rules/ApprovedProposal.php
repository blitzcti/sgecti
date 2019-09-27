<?php

namespace App\Rules;

use App\Models\Proposal;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;

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
        return __('validation.not_active');
    }
}
