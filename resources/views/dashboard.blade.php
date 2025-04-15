@extends('layouts.mainapp')

@section('title', 'Dashboard')

@section('content')
    <h2>Welcome, {{ auth()->user()->name }}</h2>
    <p>This is your dashboard content.</p>
@endsection
