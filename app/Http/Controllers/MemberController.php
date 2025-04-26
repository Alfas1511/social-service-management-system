<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'MEMBER')->get();
        return view('member.index', compact('members'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(MemberStoreRequest $request)
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
            $data->role = 'MEMBER';

            if ($request->image) {
                $image = $request->image;
                $filename = $image->getClientOriginalName();
                $data->image = $image->storeAs('user_images', time() . '_' . $filename, 'public');
            }
            $data->save();
            return redirect()->route('member.index')->with('success', 'Member Added Successfully');
        } catch (\Throwable $th) {
            info($th);
            return redirect()->route('member.create')->with('error', 'Failed');
        }
    }
    public function delete(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('member.index')->with('success', 'Member Deleted Successfully');
        } else {
            return redirect()->route('member.index')->with('error', 'Failed');
        }
    }
}
