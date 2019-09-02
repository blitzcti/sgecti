<div class="modal fade" id="searchStudentModal" tabindex="-1" role="dialog" aria-labelledby="searchStudentModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="deleteModalTitle">Pesquisar alunos</h4>
            </div>

            <div class="modal-body">
                <div class="d-flex align-items-center">
                    <form id="form" action="#" method="get" class="form-horizontal">
                        <div class="form-group">
                            <label for="inputSearch" class="col-sm-3 control-label">Pesquisar por: </label>

                            <div class="col-sm-9">
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
                                        <button type="submit" id="pesquisarRA" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
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
                            <th>Curso</th>
                            <th>Ano</th>
                            <th>Ações</th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        let s = 0;

        let courses = [
                @foreach(App\Models\Course::all()->sortBy('id') as $course)
            {
                name: '{{ $course->name }}'
            },
            @endforeach
        ];

        function Search(id) {
            s = id;

            switch (id) {
                case 0: {
                    jQuery('#searchOption').text('RA');

                    jQuery("input[id*='inputSearch']").inputmask({
                        mask: '9999999',
                        removeMaskOnSubmit: true
                    });
                    break;
                }

                case 1: {
                    jQuery('#searchOption').text('Nome');

                    jQuery("input[id*='inputSearch']").inputmask('remove');
                    break;
                }

                case 2: {
                    jQuery('#searchOption').text('Ano');

                    jQuery("input[id*='inputSearch']").inputmask({
                        mask: '9999',
                        removeMaskOnSubmit: true
                    });
                    break;
                }
            }
        }

        jQuery(document).ready(() => {
            jQuery('#form').submit(e => {
                e.preventDefault();

                let val = (s === 0 || s === 2) ? jQuery('#inputSearch').inputmask('unmaskedvalue') : jQuery('#inputSearch').val().trim();
                let filter = (s === 1 || s === 2) ? `${[{{ implode(', ', auth()->user()->coordinator_courses_id)}}].map(a => `courses[]=${a}`).join('&')}` : undefined;
                let url = (s === 0) ?
                    `/api/coordenador/aluno/${val}` : (s === 1) ?
                        `/api/coordenador/aluno?${filter}&q=${val}` :
                        `/api/coordenador/aluno/ano/${val}?${filter}`;

                if (s === 0 && val.length === 0) {
                    return;
                }

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
                            col.innerText = courses[student.course_id - 1].name;
                            row.appendChild(col);

                            col = document.createElement('td');
                            col.innerText = student.year;
                            row.appendChild(col);

                            col = document.createElement('td');
                            let a = document.createElement('a');
                            a.href = `#`;
                            a.onclick = function () {
                                jQuery('#inputRA').val(student.matricula);
                                jQuery('#inputStudentName').val(student.nome);
                                jQuery('#searchStudentModal').modal("hide");
                            };
                            a.innerText = 'Selecionar';
                            col.appendChild(a);
                            row.appendChild(col);

                            tbody.append(row);
                        });
                    },

                    error: function () {

                    }
                });
            });

            Search(s);
        });
    </script>
@endsection
