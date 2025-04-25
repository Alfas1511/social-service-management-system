@extends('layouts.mainapp')

@section('title', 'Members')

@section('content')


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Members</h4>
                        <a href="{{ route('member.create') }}" class="btn btn-sm btn-warning">Create</a>
                    </div>

                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="notification-table">
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
                                            <td>{{ Carbon\Carbon::parse($member->dob)->format('d-m-Y') }}
                                            </td>
                                            <td><img src='{{ $member->image ? asset('storage/' . $member->image) : asset('assets/dummy_user_image.jpg') }}'
                                                    style="width:80px" />
                                            </td>
                                            <td>
                                                {{-- <a href="{{ route('presidents.show', $president->id) }}" class="btn btn-sm btn-info">View</a> --}}
                                                {{-- <a href="{{ route('member.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a> --}}
                                                <form action="{{ route('member.delete', $member->id) }}" method="POST"
                                                    class="d-inline"
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
                    </div> <!-- card-body -->
                </div> <!-- card -->

            </div>
        </div>
    </div>
@endsection
