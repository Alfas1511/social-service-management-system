@extends('layouts.mainapp')

@section('title', 'President')

@section('content')
    <div class="container mt-4">

        <!-- Page Heading & Create Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Presidents</h2>
            <a href="{{ route('president.create') }}" class="btn btn-primary">+ Create President</a>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>President Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>DOB</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presidents as $president)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $president->first_name }} {{ $president->last_name }}</td>
                            <td>{{ $president->email }}</td>
                            <td>{{ $president->phone_number }}</td>
                            <td>{{ Carbon\Carbon::parse($president->dob)->format('d-m-Y') }}</td>
                            <td>
                                {{-- <a href="{{ route('presidents.show', $president->id) }}" class="btn btn-sm btn-info">View</a> --}}
                                <a href="{{ route('president.edit', $president->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('president.delete', $president->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this president?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No presidents found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
