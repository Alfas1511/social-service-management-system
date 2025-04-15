@extends('layouts.mainapp')

@section('title', 'Notebooks')

@section('content')
    <div class="container mt-4">
        <h2>Notebook Entries</h2>

        <form action="{{ route('notebooks.store') }}" method="POST">
            @csrf

            <!-- Member Select -->
            <div class="mb-3">
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
                        <label for="addAmount" class="form-label">Add Amount</label>
                        <input type="number" id="addAmount" name="amount" class="form-control" oninput="updateTotal()">
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@section('script')

<script>
    $(document).ready(function () {

        $('#memberSelect').on('change', function () {
            const memberId = $(this).val();

            if (memberId) {
                $('#inputFieldsContainer').show();

                // Fetch current total from server
                $.get(`/notebooks/member-total/${memberId}`, function (data) {
                    $('#totalAmount').val(data.total);
                });
            } else {
                $('#inputFieldsContainer').hide();
                $('#totalAmount').val('');
                $('#addAmount').val('');
            }
        });

        $('#addAmount').on('keyup input', function () {
            const addAmount = parseFloat($(this).val()) || 0;
            const currentTotal = parseFloat($('#totalAmount').val()) || 0;

            // Show live updated total (but not permanently saved yet)
            $('#totalAmount').val(currentTotal + addAmount);
        });
    });
</script>
@endsection
