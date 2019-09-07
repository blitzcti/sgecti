@extends('pdf.noimg')

@section('title', 'Relação de alunos')

@section('css')

    <style type="text/css">
        @page {
            margin: 2.9cm 1cm 0.75cm 1cm !important;
        }

        header {
            top: -72.5px !important;
        }
    </style>

@endsection

@section('content')

    @if(sizeof($students) > 0)
        <h3>Alunos que não entregaram relatório bimestral até {{ $endDate->format('d/m/Y') }}</h3>
        @foreach($courses as $course)
            @if(sizeof($students->filter(function ($s) use ($course) { return $s->course_id == $course->id; })) > 0)
                <h4>{{ $course->name }}</h4>

                @foreach($grades as $grade)
                    @if(sizeof($students->filter(function ($s) use ($course, $grade) { return $s->course_id == $course->id && $s->grade == $grade; })) > 0)

                        @foreach($classes as $class)
                            @if(sizeof($students->filter(function ($s) use ($course, $grade, $class) { return $s->course_id == $course->id && $s->grade == $grade && $s->class == $class; })) > 0)
                                <h4>
                                    @if($grade != 4)
                                        {{ $grade }}º ano {{ $class }}
                                    @else
                                        Formados, sala {{ $class }}
                                    @endif
                                </h4>

                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">RA</th>
                                        <th>Nome</th>
                                        <th>Turma</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($students->filter(function ($s) use ($course, $grade, $class) { return $s->course_id == $course->id && $s->grade == $grade && $s->class == $class; }) as $student)

                                        <tr>
                                            <th scope="row">{{ $student->matricula }}</th>
                                            <td>{{ $student->nome }}</td>
                                            <td>{{ $student->turma }}</td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endforeach

                    @endif
                @endforeach

            @endif
        @endforeach

    @endif

@endsection
