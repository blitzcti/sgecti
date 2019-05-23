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
        $state->descricao = 'Em aberto';
        $state->save();

        $state = new State();
        $state->descricao = 'Finalizado';
        $state->save();

        $state = new State();
        $state->descricao = 'Cancelado';
        $state->save();

        $state = new State();
        $state->descricao = 'Inválido';
        $state->save();
    }
}
