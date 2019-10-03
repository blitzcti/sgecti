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
        $systemConfig->name = 'Colégio Técnico Industrial "Prof. Isaac Portal Roldán"';
        $systemConfig->cep = '17033260';
        $systemConfig->uf = 'SP';
        $systemConfig->city = 'Bauru';
        $systemConfig->street = 'Avenida Nações Unidas';
        $systemConfig->number = '58-50';
        $systemConfig->district = 'Núcleo Residencial Presidente Geisel';
        $systemConfig->phone = '1431036150';
        $systemConfig->extension = null;
        $systemConfig->fax = '1431036150';
        $systemConfig->email = 'dir-cti@feb.unesp.br';
        $systemConfig->agreement_expiration = 5;
        $systemConfig->save();
    }
}
