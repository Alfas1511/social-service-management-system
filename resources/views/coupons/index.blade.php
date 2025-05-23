@extends('layouts.mainapp')

@section('title', 'Coupons')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Coupons</h4>
                        @if (auth()->user()->role == 'ADS')
                            <a href="{{ route('coupons.create') }}" class="btn btn-sm btn-warning">Create</a>
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
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Coupon</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    @forelse ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ $coupon->image ? asset('/storage/' . $coupon->image) : '--' }}"
                                                    style="width:45px" />
                                            </td>
                                            <td>{{ $coupon->description ?? '--' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($coupon->date)->format('d-m-Y') }}</td>
                                            <td>
                                                @if (Auth::user()->role == 'ADS')
                                                    <form action="{{ route('coupons.delete', $coupon->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this Coupon?');">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                @else
                                                    --
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No Coupons found !!</td>
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

        });
    </script>
@endsection
