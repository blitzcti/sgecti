<?php

use App\Models\SystemConfiguration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SystemConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $systemConfig = new SystemConfiguration();
        $systemConfig->nome = 'Colégio Técnico Industrial "Prof. Isaac Portal Roldán"';
        $systemConfig->cep = '17033260';
        $systemConfig->uf = 'SP';
        $systemConfig->cidade = 'Bauru';
        $systemConfig->rua = 'Avenida Nações Unidas';
        $systemConfig->numero = '58-50';
        $systemConfig->bairro = 'Núcleo Residencial Presidente Geisel';
        $systemConfig->fone = '1431036150';
        $systemConfig->email = 'dir-cti@feb.unesp.br';
        $systemConfig->validade_convenio = '5';
        $systemConfig->created_at = Carbon::now();
        $systemConfig->save();
    }
}
