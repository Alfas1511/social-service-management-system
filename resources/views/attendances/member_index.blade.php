@extends('layouts.mainapp')

@section('title', 'Attendance')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">My Attendance</h4>
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
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($attendances as $attendance)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}</td>
                                            <td>
                                                @if ($attendance->status == 'attended')
                                                    <span class="badge bg-success">Present</span>
                                                @else
                                                    <span class="badge bg-danger">Absent</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($attendance->hasFine)
                                                    <span class="text-danger">You are being fined</span>
                                                @else
                                                    <input type="checkbox" class="status-toggle"
                                                        data-id="{{ $attendance->id }}"
                                                        {{ $attendance->status == 'attended' ? 'checked' : '' }}> Update
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No data</td>
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

@section('script')
    <script>
        $(document).ready(function() {
            $('.status-toggle').change(function() {
                let attendanceId = $(this).data('id');
                let newStatus = $(this).is(':checked') ? 'attended' : 'unattended';

                $.ajax({
                    url: "{{ route('attendance.updateStatus') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: attendanceId,
                        status: newStatus
                    },
                    success: function(response) {
                        alert('Attendance updated.');
                        location.reload();
                    },
                    error: function() {
                        alert('Failed to update status.');
                    }
                });
            });
        });
    </script>
@endsection
