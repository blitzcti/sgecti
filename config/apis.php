<?php

return [
    /*
    |--------------------------------------------------------------------------
    | External APIs
    |--------------------------------------------------------------------------
    |
    | This file controls the external APIs used by the project.
    |
    */

    'cnpj' => [
        'url' => 'https://receitaws.com.br/v1/cnpj/{val}',
        'val' => [
            'max' => 14,
            'min' => 14,
        ],
        'error' => [
            'name' => 'status',
            'val' => 'ERROR',
        ],

        'name' => 'nome',
        'fantasyName' => 'fantasia',
        'email' => 'email',
        'phone' => 'telefone',
        'cep' => 'cep',
        'uf' => 'uf',
        'city' => 'municipio',
        'street' => 'logradouro',
        'number' => 'numero',
        'complement' => 'complemento',
        'district' => 'bairro',
    ],

    'cep' => [
        'url' => 'https://viacep.com.br/ws/{val}/json/',
        'val' => [
            'max' => 8,
            'min' => 8,
            'minVal' => 1,
        ],
        'error' => [
            'name' => 'erro',
            'val' => true,
        ],

        'uf' => 'uf',
        'city' => 'localidade',
        'street' => 'logradouro',
        'complement' => 'complemento',
        'district' => 'bairro',
    ],

    'uf' => [
        'url' => 'https://servicodados.ibge.gov.br/api/v1/localidades/municipios/{val}',
    ],

    'ufs' => [
        'url' => 'https://servicodados.ibge.gov.br/api/v1/localidades/estados',
        'column' => 'sigla',
    ],

    'cities' => [
        'url' => 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/{val}/municipios',
        'val' => [
            'max' => 2,
            'min' => 2,
        ],
        'column' => 'nome',
    ],

];
