<?php

namespace App\Http\Requests;

use App\Models\Internship;
use App\Rules\HourInterval;
use App\Rules\InternshipActive;
use Illuminate\Foundation\Http\FormRequest;

class StoreAmendment extends FormRequest
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
        $internship = Internship::find($this->get('internship'));

        return [
            'hasSchedule' => ['required', 'boolean'],
            'has2Schedules' => ['required', 'boolean'],

            'internship' => ['required', 'numeric', 'min:1', 'exists:internships,id', new InternshipActive],
            'startDate' => ['required_if:hasSchedule,1', 'nullable', 'date', 'after:' . $internship->start_date],
            'endDate' => ['required_with:startDate', 'nullable', 'date', 'after:startDate'],
            'newEndDate' => ['nullable', 'date', 'after:' . $internship->start_date],

            'monS' => [($this->get('hasSchedule')) ? 'required_without_all:tueS,wedS,thuS,friS,satS' : '', 'required_with:monE', 'nullable', 'date_format:H:i', 'before:monE'],
            'monE' => ['required_with:monS', 'nullable', 'date_format:H:i', 'after:monS', new HourInterval($this->get('monS'), $this->get('monE2'), $this->get('monS2'))],
            'tueS' => ['required_with:tueE', 'nullable', 'date_format:H:i', 'before:tueE'],
            'tueE' => ['required_with:tueS', 'nullable', 'date_format:H:i', 'after:tueS', new HourInterval($this->get('tueS'), $this->get('tueE2'), $this->get('tueS2'))],
            'wedS' => ['required_with:wedE', 'nullable', 'date_format:H:i', 'before:wedE'],
            'wedE' => ['required_with:wedS', 'nullable', 'date_format:H:i', 'after:wedS', new HourInterval($this->get('wedS'), $this->get('wedE2'), $this->get('wedS2'))],
            'thuS' => ['required_with:thuE', 'nullable', 'date_format:H:i', 'before:thuE'],
            'thuE' => ['required_with:thuS', 'nullable', 'date_format:H:i', 'after:thuS', new HourInterval($this->get('thuS'), $this->get('thuE2'), $this->get('thuS2'))],
            'friS' => ['required_with:friE', 'nullable', 'date_format:H:i', 'before:friE'],
            'friE' => ['required_with:friS', 'nullable', 'date_format:H:i', 'after:friS', new HourInterval($this->get('friS'), $this->get('friE2'), $this->get('friE2'))],
            'satS' => ['required_with:satE', 'nullable', 'date_format:H:i', 'before:satE'],
            'satE' => ['required_with:satS', 'nullable', 'date_format:H:i', 'after:satS', new HourInterval($this->get('satS'), $this->get('satS2'), $this->get('satE2'))],

            'monS2' => [($this->get('startDate') != null && $this->get('has2Schedules')) ? 'required_without_all:tueS2,wedS2,thuS2,friS2,satS2' : '', 'required_with:monE2', 'nullable', 'date_format:H:i', 'before:monE2'],
            'monE2' => ['required_with:monS2', 'nullable', 'date_format:H:i', 'after:monS2'],
            'tueS2' => ['required_with:tueE2', 'nullable', 'date_format:H:i', 'before:tueE2'],
            'tueE2' => ['required_with:tueS2', 'nullable', 'date_format:H:i', 'after:tueS2'],
            'wedS2' => ['required_with:wedE2', 'nullable', 'date_format:H:i', 'before:wedE2'],
            'wedE2' => ['required_with:wedS2', 'nullable', 'date_format:H:i', 'after:wedS2'],
            'thuS2' => ['required_with:thuE2', 'nullable', 'date_format:H:i', 'before:thuE2'],
            'thuE2' => ['required_with:thuS2', 'nullable', 'date_format:H:i', 'after:thuS2'],
            'friS2' => ['required_with:friE2', 'nullable', 'date_format:H:i', 'before:friE2'],
            'friE2' => ['required_with:friS2', 'nullable', 'date_format:H:i', 'after:friS2'],
            'satS2' => ['required_with:satE2', 'nullable', 'date_format:H:i', 'before:satE2'],
            'satE2' => ['required_with:satS2', 'nullable', 'date_format:H:i', 'after:satS2'],

            'protocol' => ['required', 'numeric', 'digits:5'],
            'observation' => ['nullable', 'max:8000'],
        ];
    }
}
