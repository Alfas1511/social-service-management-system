@extends('layouts.mainapp')

@section('title', 'Fines')

@section('content')
    <div class="container mt-4">
        <h2>My Fines</h2>

        @if (Session::has('success'))
            <p style="color:white; background-color: green; padding: 10px 5px">{{ Session::get('success') }}</p>
        @endif

        @if (Session::has('error'))
            <p style="color:white; background-color: red; padding: 10px 5px">{{ Session::get('error') }}</p>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="notification-table">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Fine Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fines as $fine)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($fine->date)->format('d-m-Y') }}</td>
                            <td>{{ $fine->amount }}</td>
                            <td>
                                @if ($fine->status == 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <a class="btn btn-sm btn-primary pay-fine-btn" data-id="{{ $fine->id }}">Pay</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.pay-fine-btn', function() {
                if (confirm('Are you sure you want to pay this fine?')) {
                    const fineId = $(this).data('id');
                    const button = $(this);
                    button.prop('disabled', true).text('Processing...');
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('fines.payFine') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: fineId,
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
                }
            });
        });
    </script>
@endsection
