<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index()
    {
        $fines = Fine::where('user_id', auth()->id())->get();
        return view('fines.index', compact('fines'));
    }

    public function updateStatus(Request $request)
    {
        $fine = Fine::findOrFail($request->id);
        $fine->status = 'paid';
        $fine->save();
        return response()->json([
            'status' => true,
            'message' => 'Fine status updated successfully',
        ]);
    }
}
