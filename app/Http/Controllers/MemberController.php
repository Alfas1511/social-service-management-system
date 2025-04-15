<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'MEMBERS')->get();
        return view('member.index', compact('members'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'nullable',
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:8',
                'dob' => 'required',
                'phone_number' => 'required',
                'image' => 'nullable',
            ]);

            $data = new User();
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->phone_number = $request->phone_number;
            $data->dob = $request->dob;
            $data->role = 'MEMBERS';

            if ($request->image) {
                $image = $request->image;
                $filename = $image->getClientOriginalName();
                $data->image = $image->storeAs('user_images', time() . '_' . $filename, 'public');
            }
            $data->save();
            return redirect()->route('member.index')->with('success', 'Member Added Successfully');
        } catch (\Throwable $th) {
            info($th);
            return redirect()->route('member.index')->with('error', 'Failed');
        }
    }
}
