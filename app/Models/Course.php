<?php

namespace App\Models;

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

    public function configurationAt($dateTime)
    {
        $config = CourseConfiguration::where('id_course', '=', $this->id)
            ->where('created_at', '<=', $dateTime)
            ->get()->sortBy('id');

        if (sizeof($config) > 0) {
            return $config->last();
        }

        return null;
    }

    public function configuration()
    {
        return $this->configurationAt(Carbon::now());
    }

    public function color()
    {
        return Color::findOrFail($this->id_color);
    }
}
