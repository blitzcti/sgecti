@extends('pdf.master')

@section('title', 'PDF')

@section('content')

    <table>
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

@endsection