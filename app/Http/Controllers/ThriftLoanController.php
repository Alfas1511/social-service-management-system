<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThriftLoanStoreRequest;
use App\Models\PaymentEntry;
use App\Models\ThriftLoan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThriftLoanController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'MEMBER')->get();
        return view('thrift_loans.index', compact('members'));
    }

    public function getMemberThriftLoanTotal(Request $request)
    {
        $data = ThriftLoan::where('user_id', $request->user_id)->first();
        if ($data) {
            return response()->json([
                'status' => true,
                'total' => $data->total_amount,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function store(ThriftLoanStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $existing_data = ThriftLoan::where('user_id', $request->member_id)->first();

            if ($existing_data) {
                $existing_data->date = Carbon::now()->format('Y-m-d');
                $existing_data->amount_paid = $request->amount;
                $existing_data->total_amount += $request->amount;
                $existing_data->save();
                if ($existing_data->id) {
                    $payment_entries = new PaymentEntry();
                    $payment_entries->user_id = $request->member_id;
                    $payment_entries->thrift_loan_id = $existing_data->id;
                    $payment_entries->paid_amount = $request->amount;
                    $payment_entries->payment_date = Carbon::now()->format('Y-m-d');
                    $payment_entries->save();
                }
            } else {
                $new_data = new ThriftLoan();
                $new_data->user_id = $request->member_id;
                $new_data->date = Carbon::now()->format('Y-m-d');
                $new_data->amount_paid = $request->amount;
                $new_data->total_amount = $request->amount;
                $new_data->save();
                if ($new_data->id) {
                    $payment_entries = new PaymentEntry();
                    $payment_entries->user_id = $new_data->user_id;
                    $payment_entries->thrift_loan_id = $new_data->id;
                    $payment_entries->paid_amount = $request->amount;
                    $payment_entries->payment_date = Carbon::now()->format('Y-m-d');
                    $payment_entries->save();
                }
            }
            DB::commit();
            return redirect()->route('thrift-loans.index')->with('success', 'Thrift Loan Amount Added!');
        } catch (\Throwable $th) {
            info($th);
            DB::rollBack();
            return redirect()->route('thrift-loans.index')->with('error', 'Failed!');
        }
    }

    public function getMemberThriftLoanPayments(Request $request)
    {
        $thriftLoan = ThriftLoan::where('user_id', $request->user_id)->first();
        $datas = PaymentEntry::where('thrift_loan_id', $thriftLoan->id)->where('user_id', $request->user_id)->get();
        if ($thriftLoan) {
            return response()->json([
                'status' => true,
                'data' => $datas,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }
}
