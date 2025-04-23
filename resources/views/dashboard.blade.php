@extends('layouts.mainapp')

@section('title', 'Dashboard')

@section('content')
    <h2>Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>
    <p>This is your dashboard content.</p>
@endsection
