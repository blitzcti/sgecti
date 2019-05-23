<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'cpf_cnpj', 'pj', 'nome', 'nome_fantasia', 'email', 'telefone', 'representante', 'cargo', 'ativo', 'id_address',
    ];

    public function address()
    {
        return Address::findOrFail($this->id_address);
    }

    public function courses()
    {
        $companyCourses = CompanyCourses::all()->where('id_company', '=', $this->id)->sortBy('id');
        $courses = [];
        foreach ($companyCourses as $companyCourse) {
            array_push($courses, Course::findOrFail($companyCourse->id_course));
        }

        return $courses;
    }

    public function sectors()
    {
        $companySectors = CompanySector::all()->where('id_company', '=', $this->id)->sortBy('id');
        $sectors = [];
        foreach ($companySectors as $companySector) {
            array_push($sectors, Sector::findOrFail($companySector->id_sector));
        }

        return $sectors;
    }

    public function supervisors()
    {
        return Supervisor::all()->where('id_company', '=', $this->id);
    }

    public function agreement()
    {
        return Agreement::all()->where('id_company', '=', $this->id);
    }
}
