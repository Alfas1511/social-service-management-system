@extends('layouts.mainapp')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <h3>Edit Profile</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" readonly
                        value="{{ old('first_name', $user->first_name) }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" readonly
                        value="{{ old('last_name', $user->last_name) }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" readonly name="email" class="form-control"
                        value="{{ old('email', $user->email) }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" readonly name="username" class="form-control"
                        value="{{ old('username', $user->username) }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control"
                        value="{{ old('phone_number', $user->phone_number) }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob', $user->dob) }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
@endsection
