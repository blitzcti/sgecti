<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'ra', 'ctps', 'company_id', 'sector_id', 'coordinator_id', 'schedule_id', 'state_id', 'data_ini',
        'data_fim', 'protocolo', 'atividades', 'observacao', 'motivo_cancelamento', 'ativo',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sector()
    {
        return $this->hasOne(Sector::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function state()
    {
        return $this->hasOne(State::class);
    }
}
