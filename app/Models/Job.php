<?php

namespace App\Models;

class Job extends Model
{
    protected $fillable = [
        'ra', 'ctps', 'company_cpf_cnpj', 'company_ie', 'company_pj', 'company_name', 'company_fantasy_name',
        'coordinator_id', 'state_id', 'start_date', 'end_date', 'protocol', 'observation', 'reason_to_cancel', 'active',
    ];

    public function student()
    {
        return $this->belongsTo(NSac\Student::class, 'ra');
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
