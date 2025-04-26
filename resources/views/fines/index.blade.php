@extends('layouts.mainapp')

@section('title', 'Fines')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">My Fines</h4>
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
                                        <th>Fine Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($fines as $fine)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($fine->date)->format('d-m-Y') }}</td>
                                            <td>{{ $fine->amount }}</td>
                                            <td>
                                                @if ($fine->status == 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <a class="btn btn-sm btn-primary pay-fine-btn"
                                                        data-id="{{ $fine->id }}">Pay</a>
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
