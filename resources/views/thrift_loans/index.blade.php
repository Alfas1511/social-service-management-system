@extends('layouts.mainapp')

@section('title', 'Thrift Loans')

@section('content')
    <div class="container mt-4">
        <h2>Thrift Loans Entries</h2>

        @if (Session::has('success'))
            <p style="color:white; background-color: green; padding: 10px 5px">{{ Session::get('success') }}</p>
        @endif

        @if (Session::has('error'))
            <p style="color:white; background-color: red; padding: 10px 5px">{{ Session::get('error') }}</p>
        @endif

        <form action="{{ route('thrift-loans.store') }}" method="POST">
            @csrf
            <!-- Member Select -->
            <div class="mb-3 col-md-6">
                <label for="memberSelect" class="form-label">Select Member</label>
                <select id="memberSelect" name="member_id" class="form-select" onchange="showInputFields(this)">
                    <option value="">-- Select a member --</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="amount-container">
                <!-- Dynamic Inputs Wrapper -->
                <div id="inputFieldsContainer" class="row" style="display: none;">
                    <div class="col-md-4 mb-3">
                        <label for="totalAmount" class="form-label">Total Amount</label>
                        <input type="text" id="totalAmount" name="total_amount" class="form-control" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="addAmount" class="form-label">Add Amount <span class="text-danger">*</span></label>
                        <input type="number" id="addAmount" name="amount" class="form-control">
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <button type="submit" class="btn btn-primary col-2 mx-3">Submit</button>
                    </div>

                </div>
            </div>

            <div id="payment-table-container" style="display: none;" class="mt-2">
                <table class="table table-bordered" id="payment-history-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>


        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#memberSelect').on('change', function() {
                const memberId = $(this).val();
                const $inputContainer = $('#inputFieldsContainer');
                const $totalAmount = $('#totalAmount');
                const $tableContainer = $('#payment-table-container');
                const $tableBody = $('#payment-history-table tbody');

                if (memberId) {
                    // Show input section
                    $inputContainer.show();

                    // Get total amount
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getMemberThriftLoanTotal') }}",
                        data: {
                            user_id: memberId
                        },
                        dataType: "json",
                        success: function(response) {
                            $totalAmount.val(response.status ? response.total : 0);
                        },
                        error: function() {
                            $totalAmount.val(0);
                        }
                    });

                    // Show table and load data
                    $tableContainer.show();
                    $tableBody.empty(); // Clear previous rows

                    $.ajax({
                        type: "GET",
                        url: "{{ route('getMemberThriftLoanPayments') }}",
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
                                        <td>${item.paid_amount}</td>
                                        <td>${item.payment_date}</td>
                                    </tr>
                                `);
                                });
                            } else {
                                $tableBody.append(`
                                <tr>
                                    <td colspan="3" class="text-center">No Payments Found</td>
                                </tr>
                            `);
                            }
                        },
                        error: function() {
                            $tableBody.append(`
                            <tr>
                                <td colspan="3" class="text-center text-danger">Failed to load data</td>
                            </tr>
                        `);
                        }
                    });

                } else {
                    // No member selected – reset everything
                    $inputContainer.hide();
                    $totalAmount.val('');
                    $tableContainer.hide();
                    $tableBody.empty();
                }
            });
        });
    </script>
@endsection
