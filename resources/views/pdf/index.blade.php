@extends('pdf.master')

@section('title', 'PDF')

@section('css')

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">

@endsection

@section('content')

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th>Nome</th>
        </tr>
        </thead>

        <tbody>
        @foreach($courses as $course)

            <tr>
                <th scope="row">{{ $course->id }}</th>
                <td>{{ $course->name }}</td>
            </tr>

        @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">RA</th>
            <th>Nome</th>
        </tr>
        </thead>

        <tbody>
        @foreach($students as $student)

            <tr>
                <th scope="row">{{ $student->matricula }}</th>
                <td>{{ $student->name }}</td>
            </tr>

        @endforeach
        </tbody>
    </table>

@endsection