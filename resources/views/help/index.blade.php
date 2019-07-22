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

            <div class="form-group">
                <label for="inputAaaa" class="col-sm-2 control-label">Algum titulo</label>

                <div class="col-sm-10">
                    <select class="form-control selection" id="inputAaaa" name="aaaaa">

                        <optgroup label="1. Configurações do sistema">
                            <option>1.1 Parâmetros do sistema</option>
                            <option>1.2 Estágio</option>
                        </optgroup>

                    </select>
                </div>
            </div>

           <h2> iNDEX</h2>
            <br>
            <p id="ConfSist" style="font-size: 22px">Configurações do sistema</h2></p>

            &nbsp1-<a href="#ConfSist">Configurações do sistema</a>
            <br>

            &emsp;1.1
            <a href="#ConfSist">Parâmetros do sistema</a> <br>
            &emsp; &emsp;1.2.1.<a href="#ConfSist">Estágio</a> <br>
<br>
            <br>
            <div class="box box-default">
                <div class="box-body">

                    <div class="form-group">
                        <label for="inputAaaa" class="col-sm-2 control-label">Funcionalidades extras</label>

                        <div class="col-sm-10">
                            <select class="form-control selection" id="inputAaaa" name="aaaaa">

                                <optgroup label="2. Funcionalidades extras">
                                    <option>2.1 Mensagem</option>
                                    <option>2.2 Logs</option>
                                </optgroup>

                            </select>
                        </div>
                    </div>
            <p id="FuncExtras" style="font-size: 22px">Funcionalidades extras</p>
            &nbsp2-  <a href="#FuncExtras">Funcionalidades extras</a> <br>
            &emsp;2.1
            <a href="#FuncExtras">Mensagem
                </a> <br>
            &emsp; &emsp;2.2<a href="#FuncExtras">Logs</a> <br>
            <br>

            <br>
            <p id="PagInicial" style="font-size: 22px">Página inicial
            </p>










                    <div class="box box-default">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="inputAaaa" class="col-sm-2 control-label">Página inicial</label>

                                <div class="col-sm-10">
                                    <select class="form-control selection" id="inputAaaa" name="aaaaa">

                                        <optgroup label="3. Página inicial">
                                            <option>2.1 Notificações</option>

                                        </optgroup>

                                    </select>
                                </div>
                            </div>







            &nbsp3-<a href="#PagInicial">Página inicial</a>
            <br>
            &emsp;3.1
            <a href="#Notifica">Notificações</a> <br>
            <br>
            <br>
            <p id="FuncSistema" style="font-size: 22px">Funcionalidades do sistema</p>




                            <div class="box box-default">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="inputAaaa" class="col-sm-2 control-label">Funcionalidades do sistema</label>

                                        <div class="col-sm-10">
                                            <select class="form-control selection" id="inputAaaa" name="aaaaa">

                                                <optgroup label="4. Funcionalidades do sistema">
                                                    <option>4.1 Estágio</option>
                                                    <option>4.1.1 Relatório bimestral</option>
                                                    <option>4.1.2 Relatório final</option>
                                                    <option>4.1.3 Visualizar estágio</option>
                                                    <option>4.1.4 Novo estágio</option>

                                                </optgroup>

                                            </select>
                                        </div>
                                    </div>



<br>
                                    <br><br>

            &emsp;4-  <a href="#FuncSistema">Funcionalidades do sistema</a> <br>
            &nbsp &emsp;4.1
            <a href="#FuncExtras">Estágio
            </a> <br>



            &emsp;&emsp;&emsp;4.1.1
            <a href="#TermoAd">Relatório bimestral</a> <br>
            &emsp;&emsp;&emsp;4.1.2
            <a href="#RelatorioFinal">Relatório final</a> <br>
            &emsp;&emsp;&emsp;4.1.3
            <a href="#VisuEstagio">Visualizar estágio</a> <br>
            &emsp;&emsp;&emsp;4.1.4
            <a href="#NovoEstagio">Novo estágio</a> <br>



            <br>


<br>




                                    <div class="box box-default">
                                        <div class="box-body">

                                            <div class="form-group">
                                                <label for="inputAaaa" class="col-sm-2 control-label">Funcionalidades do sistema</label>

                                                <div class="col-sm-10">
                                                    <select class="form-control selection" id="inputAaaa" name="aaaaa">

                                                        <optgroup label="4. Funcionalidades do sistema">
                                                            <option>4.2 Usuários</option>
                                                            <option>4.2.1 Visualizar usuários</option>
                                                            <option>4.2.2 Novo usuário</option>
                                                            <option>4.1.3 Visualizar estágio</option>
                                                            <option>4.1.4 Novo estágio</option>

                                                        </optgroup>

                                                    </select>
                                                </div>
                                            </div>


                               <br><br>

            &emsp;&emsp;4.2
            <a href="#Usuarios">Usuários</a> <br>
            &emsp;&emsp;&emsp;4.2.1
            <a href="#VisUsuarios">Visualizar usuários</a> <br>
            &emsp;&emsp;&emsp;4.2.2
            <a href="#NovoUsuario">Novo usuário </a> <br>





            <br>


<br>




                                            <div class="box box-default">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="inputAaaa" class="col-sm-2 control-label">Funcionalidades do sistema</label>

                                                        <div class="col-sm-10">
                                                            <select class="form-control selection" id="inputAaaa" name="aaaaa">

                                                                <optgroup label="4. Funcionalidades do sistema">
                                                                    <option>4.3 Cursos</option>
                                                                    <option>4.3.1 Visualizar cursos</option>
                                                                    <option>4.3.2 Novo curso</option>

                                                                </optgroup>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <br><br>

            &emsp;&emsp;4.3
            <a href="#Cursos">Cursos</a> <br>
            &emsp;&emsp;&emsp;4.3.1
            <a href="#VisuCuros">Visualizar cursos</a> <br>
            &emsp;&emsp;&emsp;4.3.2
            <a href="#NovoCurso">Novo curso </a> <br>


            <br>
            <br>




                                                    <div class="box box-default">
                                                        <div class="box-body">

                                                            <div class="form-group">
                                                                <label for="inputAaaa" class="col-sm-2 control-label">Funcionalidades do sistema</label>

                                                                <div class="col-sm-10">
                                                                    <select class="form-control selection" id="inputAaaa" name="aaaaa">

                                                                        <optgroup label="4. Funcionalidades do sistema">
                                                                            <option>4.4 Coordenadores</option>
                                                                            <option>4.4.1 Visualizar coordenadores</option>
                                                                            <option>4.4.2 Novo coordenador </option>

                                                                        </optgroup>

                                                                    </select>
                                                                </div>
                                                            </div>

<br><br>
            &emsp;&emsp;4.4
            <a href="#Coodenadores">Coordenadores</a> <br>
            &emsp;&emsp;&emsp;4.4.1
            <a href="#VisuCoordenadores">Visualizar coordenadores</a> <br>
            &emsp;&emsp;&emsp;4.4.2
            <a href="#NovoCoordenador">Novo coordenador </a> <br>


            <br>
            <br>



                                                            <div class="box box-default">
                                                                <div class="box-body">

                                                                    <div class="form-group">
                                                                        <label for="inputAaaa" class="col-sm-2 control-label">Funcionalidades do sistema</label>

                                                                        <div class="col-sm-10">
                                                                            <select class="form-control selection" id="inputAaaa" name="aaaaa">

                                                                                <optgroup label="4. Funcionalidades do sistema">
                                                                                    <option>4.5 Alunos</option>
                                                                                    <option>4.5.1 Histórico</option>


                                                                                </optgroup>

                                                                            </select>
                                                                        </div>
                                                                    </div>


                                                     <br><br>








            &emsp;&emsp;4.5
            <a href="#Alunos">Alunos</a> <br>
            &emsp;&emsp;&emsp;4.5.1
            <a href="#Historicos">Histórico</a> <br>
            <br>
            <br>




                                                                    <div class="box box-default">
                                                                        <div class="box-body">

                                                                            <div class="form-group">
                                                                                <label for="inputAaaa" class="col-sm-2 control-label">Funcionalidades do sistema</label>

                                                                                <div class="col-sm-10">
                                                                                    <select class="form-control selection" id="inputAaaa" name="aaaaa">

                                                                                        <optgroup label="4. Funcionalidades do sistema">
                                                                                            <option>4.6 Empresas</option>
                                                                                            <option>4.6.1 Visualizar empresas</option>
                                                                                            <option>4.6.2 Nova empresa</option>
                                                                                            <option>4.6.3 Convênio de Empresas</option>


                                                                                        </optgroup>

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <br><br>
            &emsp;&emsp;4.6
            <a href="#Empresas">Empresas</a> <br>
            &emsp;&emsp;&emsp;4.6.1
            <a href="#VisualizarEmpresas"> Visualizar empresas</a> <br>
            &emsp;&emsp;&emsp;4.6.2
            <a href="#NovoCoordenador"> Nova empresa</a> <br>
            &emsp;&emsp;&emsp;4.6.3
            <a href="#ConvênioEmpresas"> Convênio de Empresas</a> <br>



            <br>
            <p id="PagInicial">Página inicial
            </p>
            <!--
-------------------------------------------------------------------------------------------------------------
                <p id="Notifica">Notificações</p>
-------------------------------------------------------------------------------------------------------------
            <p id="NovoPlano">Novo plano de Estagio</p>
-------------------------------------------------------------------------------------------------------------
            <p id="Coodenadores">Coodenadores</p>
-------------------------------------------------------------------------------------------------------------
            <p id="VisuCoordenadores">Visualizar coordenadores</p>
-------------------------------------------------------------------------------------------------------------
            <p id="NovoCurso">Novo curso</p>
-------------------------------------------------------------------------------------------------------------
            <p id="NovoEstagio">Novo estágio</p>
-------------------------------------------------------------------------------------------------------------
            <p id="ConfSist">Configurações do sistema</p>
-------------------------------------------------------------------------------------------------------------
            <p id="FuncExtras">Funcionalidades extras</p>
-------------------------------------------------------------------------------------------------------------
            <p id="FuncSistema">Funcionalidades do sistema</p>
-------------------------------------------------------------------------------------------------------------
            <p id="Estagio">Estágio</p>
-------------------------------------------------------------------------------------------------------------
            <p id="Estagio">Relatório bimestral</p>
-------------------------------------------------------------------------------------------------------------
            <p id="NovoCoordenador">Novo coordenador</p>
-------------------------------------------------------------------------------------------------------------
            <p id="Alunos">Alunos</p>
-------------------------------------------------------------------------------------------------------------
            <p id="Historicos">Historicos</p>

-------------------------------------------------------------------------------------------------------------
            <p id="Empresas">Empresas</p>
-------------------------------------------------------------------------------------------------------------
            <p id="VisualizarEmpresas">Visualizar empresas</p>
-------------------------------------------------------------------------------------------------------------
            <p id="ConvênioEmpresas">Convênio de Empresas</p>

            -->

        </div>
    </div>
@endsection
