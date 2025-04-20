@extends('layouts.mainapp')

@section('title', 'Notebooks')

@section('content')
    <div class="container mt-4">
        <h2>Notebook Amount Entries</h2>

        @if (Session::has('success'))
            <p style="color:white; background-color: green; padding: 10px 5px">{{ Session::get('success') }}</p>
        @endif

        @if (Session::has('error'))
            <p style="color:white; background-color: red; padding: 10px 5px">{{ Session::get('error') }}</p>
        @endif

        <form action="{{ route('notebooks.store') }}" method="POST">
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
        $(document).ready(function() {

            $('#memberSelect').on('change', function() {
                const memberId = $(this).val();

                if (memberId) {
                    $('#inputFieldsContainer').show();
                    $.ajax({
                        type: "get",
                        url: "{{ route('getMemberNotebookTotal') }}",
                        data: {
                            user_id: memberId,
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status) {
                                $('#totalAmount').val(response.total);
                            } else {
                                $('#totalAmount').val(0);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
