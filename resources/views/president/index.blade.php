@extends('layouts.mainapp')

@section('title', 'President')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Presidents</h4>
                        @if (auth()->user()->role == 'ADS')
                            <a href="{{ route('president.create') }}" class="btn btn-sm btn-warning">Create</a>
                        @endif
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
                                        <th>President Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>DOB</th>
                                        <th>Photo</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($presidents as $president)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $president->first_name }} {{ $president->last_name }}
                                            </td>
                                            <td>{{ $president->email }}</td>
                                            <td>{{ $president->phone_number }}</td>
                                            <td>{{ Carbon\Carbon::parse($president->dob)->format('d-m-Y') }}
                                            </td>
                                            <td><img src='{{ $president->image ? asset('storage/' . $president->image) : asset('assets/dummy_user_image.jpg') }}'
                                                    style="width:80px" />
                                            </td>
                                            <td>
                                                <form action="{{ route('president.delete', $president->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this president?');">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No presidents found.</td>
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
