@extends('emails.master')

@section('title', $title)

@section('content')
    <p>{!! $messageBody !!}</p>
@endsection
