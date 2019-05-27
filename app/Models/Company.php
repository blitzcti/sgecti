<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'cpf_cnpj', 'pj', 'nome', 'nome_fantasia', 'email', 'telefone', 'representante', 'cargo', 'ativo', 'address_id',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function courses()
    {
        return $this->hasMany(CompanyCourses::class);
    }

    public function sectors()
    {
        return $this->hasMany(CompanySector::class);
    }

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }

    public function agreement()
    {
        return $this->hasMany(Agreement::class);
    }

    public function syncCourses($courses)
    {
        $companyCourses = $this->courses;
        foreach ($companyCourses as $companyCourse) {
            $companyCourse->delete();
        }

        foreach ($courses as $course) {
            $companyCourse = new CompanyCourses();
            $companyCourse->company_id = $this->id;
            $companyCourse->course_id = intval($course);
            $companyCourse->save();
        }
    }

    public function syncSectors($sectors)
    {
        $companySectors = $this->sectors;
        foreach ($companySectors as $companySector) {
            $companySector->delete();
        }

        foreach ($sectors as $sector) {
            $companySector = new CompanySector();
            $companySector->company_id = $this->id;
            $companySector->course_id = intval($sector);
            $companySector->save();
        }
    }
}
