<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'id_color', 'active',
    ];

    public function coordinatorAt($date)
    {
        $coordinator = Coordinator::where('id_course', '=', $this->id)
            ->where(function ($query) use ($date) {
                $query->where('vigencia_fim', '=', null)
                    ->orWhere('vigencia_fim', '>=', $date);
            })
            ->get()->sortBy('id');

        if (sizeof($coordinator) > 0) {
            return $coordinator->last();
        }

        return null;
    }

    public function coordinator()
    {
        return $this->coordinatorAt(Carbon::today()->toDateString());
    }
}
