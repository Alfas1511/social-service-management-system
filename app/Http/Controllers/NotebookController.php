<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use App\Models\User;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'MEMBERS')->get();
        return view('notebooks.index', compact('members'));
    }

    public function getMemberTotal($memberId)
    {
        $notebook = Notebook::where('member_id', $memberId)->first();

        return response()->json([
            'total' => $notebook ? $notebook->total_amount : 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $notebook = Notebook::firstOrCreate(
            ['member_id' => $request->member_id],
            ['total_amount' => 0]
        );

        $notebook->total_amount += $request->amount;
        $notebook->save();

        return redirect()->back()->with('success', 'Notebook updated successfully!');
    }
}
