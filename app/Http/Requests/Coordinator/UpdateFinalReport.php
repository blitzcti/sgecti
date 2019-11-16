<?php

namespace App\Http\Requests\Coordinator;

use App\Rules\Integer;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFinalReport extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reportDate' => ['required', 'date'],

            'grade_1_a' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_1_b' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_1_c' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_2_a' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_2_b' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_2_c' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_2_d' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_3_a' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_3_b' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_4_a' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_4_b' => ['required', 'integer', 'min:1', 'max:6'],
            'grade_4_c' => ['required', 'integer', 'min:1', 'max:6'],

            'completedHours' => ['required', new Integer, 'min:1', 'max:9999'],
            'endDate' => ['required', 'date'],

            'observation' => ['nullable', 'max:8000'],
        ];
    }
}
