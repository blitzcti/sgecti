<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new App\User();
        $user->password = Hash::make('123456789'); //Admin password
        $user->email = 'dir-cti@feb.unesp.br';
        $user->name = 'Administrador';
        $user->assignRole('admin');
        $user->save();
    }
}
