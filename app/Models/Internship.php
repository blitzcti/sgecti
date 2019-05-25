<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'ra', 'ctps_id', 'company_id', 'sector_id', 'coordinator_id', 'schedule_id', 'state_id', 'data_ini',
        'data_fim', 'protocolo', 'atividades', 'observacao', 'motivo_cancelamento', 'ativo',
    ];

    public function ctps()
    {
        return $this->hasOne(CTPS::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function sector()
    {
        return $this->hasOne(Sector::class);
    }

    public function coordinator()
    {
        return $this->hasOne(Coordinator::class);
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function state()
    {
        return $this->hasOne(State::class);
    }
}
