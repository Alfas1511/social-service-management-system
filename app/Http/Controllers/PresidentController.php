<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresidentStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PresidentController extends Controller
{
    public function index()
    {
        $presidents = User::where('role', 'PRESIDENT')->get();
        return view('president.index', compact('presidents'));
    }

    public function create()
    {
        return view('president.create');
    }

    public function store(PresidentStoreRequest $request)
    {
        try {
            $data = new User();
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->phone_number = $request->phone_number;
            $data->dob = $request->dob;
            $data->role = 'PRESIDENT';

            if ($request->image) {
                $image = $request->image;
                $filename = $image->getClientOriginalName();
                $data->image = $image->storeAs('user_images', time() . '_' . $filename, 'public');
            }
            $data->save();
            return redirect()->route('president.index')->with('success', 'President Added Successfully');
        } catch (\Throwable $th) {
            info($th);
            return redirect()->route('president.create')->with('error', 'Failed');
        }
    }

    public function delete(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('president.index')->with('success', 'President Deleted Successfully');
        } else {
            return redirect()->route('president.index')->with('error', 'Failed');
        }
    }
}
