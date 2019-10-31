@extends('modals.error', ['id' => 'companyErrorModal'])

@section('modalTitle')
    Empresa já cadastrada
@overwrite

@section('modalText')
    <p>O CPF/CNPJ informado já está cadastrado.</p>
@overwrite
