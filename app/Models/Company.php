<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Model for companies table.
 *
 * @package App\Models
 * @property int id
 * @property string cpf_cnpj
 * @property string ie
 * @property boolean pj
 * @property string name
 * @property string fantasy_name
 * @property string email
 * @property string phone
 * @property string representative_name
 * @property string representative_role
 * @property boolean active
 * @property int address_id
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Address address
 * @property Collection|Course[] courses
 * @property Collection|Sector[] sectors
 * @property Collection|Supervisor[] supervisors
 * @property Collection|Agreement[] agreements
 * @property Collection|Internship[] internships
 * @property Collection|Proposal[] proposals
 * @property User user
 * @property-read string formatted_cpf_cnpj
 * @property-read string formatted_phone
 */
class Company extends Model
{
    protected $fillable = [
        'cpf_cnpj', 'ie', 'pj', 'name', 'fantasy_name', 'email', 'phone', 'representative_name', 'representative_role',
        'active', 'address_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'pj' => 'boolean',
        'address_id' => 'integer',

        'active' => 'boolean',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'company_has_courses');
    }

    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'company_has_sectors');
    }

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function hasAgreementAt(Carbon $date = null)
    {
        if ($date == null) {
            $date = Carbon::now();
        }

        /* @var $agreement Agreement */
        foreach ($this->agreements as $agreement) {
            $endDate = $agreement->end_date;
            $endDate->modify('-1 day');
            if ($agreement->active && $date->between($agreement->start_date, $endDate)) {
                return true;
            }
        }

        return false;
    }

    public function syncCourses($courses)
    {
        $this->courses()->sync($courses);
    }

    public function syncSectors($sectors)
    {
        $this->sectors()->sync($sectors);
    }

    public function getFormattedCpfCnpjAttribute()
    {
        $cpf_cnpj = $this->cpf_cnpj;
        if ($this->pj) {
            $p1 = substr($cpf_cnpj, 0, 2);
            $p2 = substr($cpf_cnpj, 2, 3);
            $p3 = substr($cpf_cnpj, 5, 3);
            $p4 = substr($cpf_cnpj, 8, 4);
            $p5 = substr($cpf_cnpj, 12, 2);
            return "$p1.$p2.$p3/$p4-$p5";
        } else {
            $p1 = substr($cpf_cnpj, 0, 3);
            $p2 = substr($cpf_cnpj, 3, 3);
            $p3 = substr($cpf_cnpj, 6, 3);
            $p4 = substr($cpf_cnpj, 9, 2);
            return "$p1.$p2.$p3-$p4";
        }
    }

    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone;
        if ($phone == null) {
            return null;
        }

        $ddd = substr($phone, 0, 2);
        $p1 = (strlen($phone) == 10) ? substr($phone, 2, 4) : substr($phone, 2, 5);
        $p2 = (strlen($phone) == 10) ? substr($phone, 6, 4) : substr($phone, 7, 4);
        return "($ddd) $p1-$p2";
    }
}
