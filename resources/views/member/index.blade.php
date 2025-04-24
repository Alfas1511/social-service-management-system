@extends('layouts.mainapp')

@section('title', 'Members')

@section('content')
    <div class="container mt-4">

        <!-- Page Heading & Create Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Members</h2>
            <a href="{{ route('member.create') }}" class="btn btn-primary">+ Create Member</a>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-success">{{ session('error') }}</div>
        @endif

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Member Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>DOB</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->phone_number }}</td>
                            <td>{{ Carbon\Carbon::parse($member->dob)->format('d-m-Y') }}</td>
                            <td><img src='{{ $member->image ? asset('storage/' . $member->image) : asset('assets/dummy_user_image.jpg') }}'
                                    style="width:80px" />
                            </td>
                            <td>
                                {{-- <a href="{{ route('presidents.show', $president->id) }}" class="btn btn-sm btn-info">View</a> --}}
                                {{-- <a href="{{ route('member.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a> --}}
                                <form action="{{ route('member.delete', $member->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this member?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
