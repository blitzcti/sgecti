@extends('modals.errorModal', ['id' => 'cnpjErrorModal'])

@section('modalTitle')
    CNPJ não encontrado
@overwrite

@section('modalText')
    <p>O CNPJ informado não foi localizado.</p>
@overwrite
