<?php

use App\Models\User;
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
        $user = new User();
        $user->password = Hash::make('123456789');
        $user->email = 'dir-cti@feb.unesp.br';
        $user->phone = '1431036150';
        $user->name = 'Administrador';
        $user->assignRole('admin');
        $user->save();
    }
}
