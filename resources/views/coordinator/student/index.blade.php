@extends('adminlte::page')

@section('title', 'Alunos - SGE CTI')

@section('content_header')
    <h1>Alunos</h1>
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
        <div class="box-header with-border">

        </div>

        <div class="box-body">
            <form action="" class="form-horizontal">
                <div class="form-group">
                    <label for="inputSearch" class="col-sm-2 control-label">Pesquisa por: </label>

                    <div class="col-sm-10">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle"
                                        data-toggle="dropdown">
                                    <span id="searchOption"></span>
                                    <span class="fa fa-caret-down"></span></button>

                                <ul class="dropdown-menu">
                                    <li><a href="#" onclick="Search(0); return false;">RA</a></li>
                                    <li><a href="#" onclick="Search(1); return false;">Nome</a></li>
                                    <li><a href="#" onclick="Search(2); return false;">Ano</a></li>
                                </ul>
                            </div>

                            <input type="text" class="form-control" id="inputSearch" name="search"/>

                            <div class="input-group-btn">
                                <button type="button" id="pesquisarRA" class="btn btn-primary">Pesquisar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <table id="students" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>RA</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Email 2</th>
                </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        let s = 0;

        function Search(id) {
            s = id;

            switch (id) {
                case 0: {
                    jQuery('#searchOption').text('RA');

                    $("input[id*='inputSearch']").inputmask({
                        mask: '9999999',
                        removeMaskOnSubmit: true
                    });
                    break;
                }

                case 1: {
                    jQuery('#searchOption').text('Nome');

                    $("input[id*='inputSearch']").inputmask('remove');
                    break;
                }

                case 2: {
                    jQuery('#searchOption').text('Ano');

                    $("input[id*='inputSearch']").inputmask({
                        mask: '9999',
                        removeMaskOnSubmit: true
                    });
                    break;
                }
            }
        }

        jQuery(() => {
            jQuery('#pesquisarRA').on('click', () => {
                let url = (s === 0) ? `/api/aluno/${jQuery('#inputSearch').inputmask('unmaskedvalue')}` :
                    (s === 1) ? `/api/aluno?q=${jQuery('#inputSearch').val()}` : `/api/aluno/ano/${jQuery('#inputSearch').inputmask('unmaskedvalue')}`;

                jQuery.ajax({
                    url: url,
                    dataType: 'json',
                    method: 'GET',
                    success: function (students) {
                        let tbody = jQuery('#students tbody');
                        tbody.empty();

                        students.forEach(student => {
                            let row = document.createElement('tr');
                            let col = document.createElement('td');
                            col.innerText = student.matricula;
                            row.appendChild(col);

                            col = document.createElement('td');
                            col.innerText = student.nome;
                            row.appendChild(col);

                            col = document.createElement('td');
                            col.innerText = student.email;
                            row.appendChild(col);

                            col = document.createElement('td');
                            col.innerText = student.email2;
                            row.appendChild(col);

                            tbody.append(row);
                        });
                    },

                    error: function () {
                        console.log('deu merda');
                    }
                });
            });

            Search(s);
        });
    </script>
@endsection
