@extends('layouts.mainapp')

@section('title', 'Attendances')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Attendances</h2>

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

        <form action="{{ route('dates.store') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-md-4">
                <label for="date" class="form-label">Select Date</label>
                <input type="date" id="date" name="date" class="form-control">
                @error('date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </form>

        <div class="row mt-4">
            <div class="col-md-6">
                <label for="memberSelect" class="form-label">Select Member</label>
                <select id="memberSelect" name="member_id" class="form-select">
                    <option value="">-- Select a member --</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="attendance-table-container" style="display: none;" class="mt-4">
            <h5 class="mb-3">Attendance Records</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center" id="attendance-table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Member</th>
                            <th>Status</th>
                            <th>Take Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#memberSelect').on('change', function() {
                const memberId = $(this).val();
                const $tableContainer = $('#attendance-table-container');
                const $tableBody = $('#attendance-table tbody');

                if (memberId) {
                    $tableContainer.show();
                    $tableBody.empty();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('getMemberAttendances') }}",
                        data: {
                            user_id: memberId
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status && response.data.length > 0) {
                                response.data.forEach((item, index) => {
                                    $tableBody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.date}</td>
                                        <td>${item.member}</td>
                                        <td>${item.status}</td>
                                        <td>${item.fine}</td>
                                    </tr>
                                `);
                                });
                            } else {
                                $tableBody.append(`
                                <tr>
                                    <td colspan="6  " class="text-muted">No Attendances Found</td>
                                </tr>
                            `);
                            }
                        },
                        error: function() {
                            $tableBody.append(`
                            <tr>
                                <td colspan="6" class="text-danger">Failed to load data</td>
                            </tr>
                        `);
                        }
                    });
                } else {
                    $tableContainer.hide();
                    $tableBody.empty();
                }
            });

            $(document).on('click', '.give-fine-btn', function() {
                const attendanceId = $(this).data('id');
                const button = $(this);
                button.prop('disabled', true).text('Processing...');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('attendance.givefine') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: attendanceId,
                    },
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('Something went wrong.');
                        button.prop('disabled', false).text('Give Fine');
                    }
                });
            });
        });
    </script>
@endsection
