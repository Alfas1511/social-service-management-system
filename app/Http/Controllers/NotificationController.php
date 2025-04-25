<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationStoreRequest;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::get();
        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('notifications.create');
    }

    public function store(NotificationStoreRequest $request)
    {
        try {
            $data = new Notification();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->date = Carbon::now()->format('Y-m-d');
            $data->save();
            return redirect()->route('notifications.index')->with('success', 'Notification Added Successfully');
        } catch (\Throwable $th) {
            info($th);
            return redirect()->route('notifications.create')->with('error', 'Failed');
        }
    }

    public function delete(string $id)
    {
        $data = Notification::find($id);
        if ($data) {
            $data->save();
            return redirect()->route('notifications.index')->with('success', 'Notification Deleted Successfully');
        } else {
            return redirect()->route('notifications.index')->with('error', 'Failed');
        }
    }
}
