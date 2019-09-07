<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;

class Agreement extends Model
{
    protected $fillable = [
        'company_id', 'start_date', 'end_date', 'observation', 'active',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function createUser()
    {
        $user = new User();
        $user->password = Hash::make('123456789');
        $user->email = $this->company->email;
        $user->phone = null;
        $user->name = $this->company->representative_name;
        $user->assignRole('company');
        return $user->save();
    }
}
