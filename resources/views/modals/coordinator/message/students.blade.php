<div class="modal fade" id="messageStudentsModal" tabindex="-1" role="dialog" aria-labelledby="messageStudentsModal"
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
                    <table id="students" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>RA</th>
                            <th>Nome</th>
                            <th>Curso</th>
                            <th>Turma</th>
                            <th>Ano</th>
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
        let courses = [
                @foreach(App\Models\Course::all()->sortBy('id') as $course)
            {
                name: '{{ $course->name }}'
            },
            @endforeach
        ];

        function getClasses() {
            return jQuery('#inputClasses').val();
        }

        function getGrades() {
            return jQuery('#inputGrades').val();
        }

        function getPeriods() {
            return jQuery('#inputPeriods').val();
        }

        function getCourses() {
            return jQuery('#inputCourses').val();
        }

        function getInternshipState() {
            return jQuery('#inputInternships').val();
        }

        function loadStudents() {
            let cs = getClasses().map(c => `&classes[]=${c}`).join('');
            let gs = getGrades().map(g => `&grades[]=${g}`).join('');
            let ps = getPeriods().map(p => `&periods[]=${p}`).join('');
            let Cs = getCourses().map(C => `&courses[]=${C}`).join('');
            let es = getInternshipState().map(e => `&istates[]=${e}`).join('');

            if (cs.length === gs.length && gs.length === ps.length && ps.length === Cs.length && Cs.length === es.length && es.length === 0) {
                return;
            } else {
                jQuery('#messageStudentsModal').modal('show');
            }

            if (Cs.length === 0) {
                Cs = [{{ implode(", ", \App\Auth::user()->coordinator_courses_id) }}].map(c => `&courses[]=${c}`);
            }

            let url = `{{ config('app.url') ?? '' }}/api/alunos?q=`;
            if (cs.length > 0) {
                url += cs;
            }

            if (gs.length > 0) {
                url += gs;
            }

            if (ps.length > 0) {
                url += ps;
            }

            if (Cs.length > 0) {
                url += Cs;
            }

            if (es.length > 0) {
                url += es;
            }

            jQuery.ajax({
                url: url,
                dataType: 'json',
                method: 'GET',
                success: function (students) {
                    let tbody = jQuery('#students tbody');
                    tbody.empty();

                    students.forEach(student => {
                        if (student.situacao_matricula === 0 || student.situacao_matricula === 5) {
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
                            col.innerText = student.class;
                            row.appendChild(col);

                            col = document.createElement('td');
                            col.innerText = student.year;
                            row.appendChild(col);

                            tbody.append(row);
                        }
                    });
                },

                error: function () {

                }
            });
        }
    </script>
@endsection
