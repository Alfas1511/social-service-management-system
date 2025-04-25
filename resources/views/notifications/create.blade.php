@extends('layouts.mainapp')

@section('title', 'Create Notification')

@section('content')
    <div class="container mt-4">
        <h2>Create Notification</h2>

        @if (Session::has('success'))
            <p style="color:white; background-color: green; padding: 10px 5px">{{ Session::get('success') }}</p>
        @endif

        @if (Session::has('error'))
            <p style="color:white; background-color: red; padding: 10px 5px">{{ Session::get('error') }}</p>
        @endif

        <form action="{{ route('notifications.store') }}" method="POST">
            @csrf

            <div class="mb-3 col-md-6">
                <label for="image" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" id="title" name="title" class="form-control">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="description" class="form-label">Description</label>
                <textarea type="text" id="description" name="description" class="form-control"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <button type="submit" class="btn btn-primary col-2 mx-3">Submit</button>
            </div>
        </form>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
