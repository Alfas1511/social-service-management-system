@extends('layouts.mainapp')

@section('title', 'Attendance')

@section('content')
    <div class="container mt-4">
        <h2>My Attendance</h2>

        @if (Session::has('success'))
            <p style="color:white; background-color: green; padding: 10px 5px">{{ Session::get('success') }}</p>
        @endif

        @if (Session::has('error'))
            <p style="color:white; background-color: red; padding: 10px 5px">{{ Session::get('error') }}</p>
        @endif

        <div class="mt-2">
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
                        @foreach ($attendances as $attendance)
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
                                        <input type="checkbox" class="status-toggle" data-id="{{ $attendance->id }}"
                                            {{ $attendance->status == 'attended' ? 'checked' : '' }}> Update
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
