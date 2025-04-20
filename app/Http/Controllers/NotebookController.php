<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use App\Models\PaymentEntry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotebookController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'MEMBERS')->get();
        return view('notebooks.index', compact('members'));
    }

    public function getMemberTotal(Request $request)
    {
        $notebook = Notebook::where('user_id', $request->user_id)->first();
        if ($notebook) {
            return response()->json([
                'status' => true,
                'total' => $notebook->total_amount,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'member_id' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:0',
            ]);

            $existing_data = Notebook::where('user_id', $request->member_id)->first();
            if ($existing_data) {
                $existing_data->date = Carbon::now()->format('Y-m-d');
                $existing_data->amount_paid = $request->amount;
                $existing_data->total_amount += $request->amount;
                $existing_data->save();
                if ($existing_data->id) {
                    $payment_entries = new PaymentEntry();
                    $payment_entries->user_id = $request->member_id;
                    $payment_entries->notebook_id = $existing_data->id;
                    $payment_entries->paid_amount = $request->amount;
                    $payment_entries->payment_date = Carbon::now()->format('Y-m-d');
                    $payment_entries->save();
                }
            } else {
                $new_data = new Notebook();
                $new_data->user_id = $request->member_id;
                $new_data->date = Carbon::now()->format('Y-m-d');
                $new_data->amount_paid = $request->amount;
                $new_data->total_amount = $request->amount;
                $new_data->save();
                if ($new_data->id) {
                    $payment_entries = new PaymentEntry();
                    $payment_entries->user_id = $new_data->user_id;
                    $payment_entries->notebook_id = $new_data->id;
                    $payment_entries->paid_amount = $request->amount;
                    $payment_entries->payment_date = Carbon::now()->format('Y-m-d');
                    $payment_entries->save();
                }
            }
            DB::commit();
            return redirect()->route('notebooks.index')->with('success', 'Notebook Data Added!');
        } catch (\Throwable $th) {
            info($th);
            dd($th);
            DB::rollBack();
            return redirect()->route('notebooks.index')->with('error', 'Failed!');
        }
    }
}
