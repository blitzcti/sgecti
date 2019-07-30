<?php

use App\Models\State;
use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $state = new State();
        $state->description = 'Em aberto';
        $state->save();

        $state = new State();
        $state->description = 'Finalizado';
        $state->save();

        $state = new State();
        $state->description = 'Cancelado';
        $state->save();

        $state = new State();
        $state->description = 'Inválido';
        $state->save();
    }
}
