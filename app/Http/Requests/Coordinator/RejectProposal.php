<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Proposal;
use App\Rules\Route;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class RejectProposal extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $proposal = Proposal::findOrFail($this->route('id'));

        return $proposal->deadline >= Carbon::today() && $proposal->approved_at == null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reasonToReject' => ['required', 'max:8000'],
            'redirectTo' => ['nullable', new Route],
        ];
    }
}
