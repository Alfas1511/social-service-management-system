<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponStoreRequest;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::get();
        return view('coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupons.create');
    }

    public function store(CouponStoreRequest $request)
    {
        try {
            $data = new Coupon();
            if ($request->image) {
                $coupon = $request->image;
                $couponName = time() . '.' . $coupon->getClientOriginalExtension();
                $data->image = $coupon->storeAs('coupons', $couponName, 'public');
                $data->description = $request->description;
                $data->date = Carbon::now()->format('Y-m-d');
                $data->save();
            }
            return redirect()->route('coupons.index')->with('success', 'Coupon Added Successfully');
        } catch (\Throwable $th) {
            info($th);
            return redirect()->route('coupons.create')->with('error', 'Failed');
        }
    }

    public function delete(string $id)
    {
        $data = Coupon::find($id);
        if ($data) {
            $data->save();
            return redirect()->route('coupons.index')->with('success', 'Coupon Deleted Successfully');
        } else {
            return redirect()->route('coupons.index')->with('error', 'Failed');
        }
    }
}
