@extends('adminlte::page')

@section('title', 'Ajuda - SGE CTI')

@section('content_header')
    <h1>Ajuda</h1>
@stop

@section('content')
    @if(session()->has('message'))
        <div class="alert {{ session('saved') ? 'alert-success' : 'alert-error' }} alert-dismissible"
             role="alert">
            {{ session()->get('message') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="box box-default">
        <div class="box-body">

           <h2> Ajuda do Sistema</h2>
            <br>
            &nbsp1-Iniciando Navegação <br>
            &nbsp2-Login <br>
            &nbsp3-O Sistema <br>
            &emsp;3.1
            <a href="#PerfilUsu">Perfil Usuario</a> <br>
            &emsp;&emsp;3.1.1
            <a href="#Alertas">Alertas</a> <br>
            &emsp;3.2.Coordenadoria <br>
            &emsp; &emsp;3.2.1.Estágio <br>
            &emsp;&emsp;&emsp;3.2.1.1
            <a href="#NovoPlano">Novo plano de Estagio</a> <br>
            &emsp;&emsp;&emsp;3.2.1.2
            <a href="#TermoAd">Termo Aditivo</a> <br>
            &emsp;&emsp;&emsp;3.2.1.3
            <a href="#CadCTPS">Cadastrar CTPS</a> <br>
            &emsp;&emsp;&emsp;3.2.1.4
            <a href="#VisuCTPS">Visualizar CTPS</a> <br>
            &emsp;&emsp;&emsp;3.2.1.5
            <a href="#CancelaCTPS">Cancelar CTPS</a> <br>


-------------------------------------------------------------------------------------------------------------
            <p id="PerfilUsu">Perfil Usuario</p>
-------------------------------------------------------------------------------------------------------------
            <p id="Alertas">Alertas</p>
-------------------------------------------------------------------------------------------------------------
            <p id="NovoPlano">Novo plano de Estagio</p>
-------------------------------------------------------------------------------------------------------------
            <p id="TermoAd">Termo Aditivo</p>
-------------------------------------------------------------------------------------------------------------
            <p id="CadCTPS">Cadastrar CTPS</p>
-------------------------------------------------------------------------------------------------------------
            <p id="VisuCTPS">Visualizar CTPS</p>
-------------------------------------------------------------------------------------------------------------
            <p id="CancelaCTPS">Cancelar CTPS</p>

        </div>
    </div>
@endsection
