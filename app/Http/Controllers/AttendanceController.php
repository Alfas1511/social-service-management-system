<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'MEMBER') {
            $attendances = Attendance::where('user_id', auth()->id())->get();
            return view('attendances.member_index', compact('attendances'));
        }
        if (auth()->user()->role == 'PRESIDENT') {
            $attendances = Attendance::get();
            $members = User::where('role', 'MEMBER')->get();
            return view('attendances.president_index', compact('attendances', 'members'));
        }
    }

    public function dateStore(Request $request)
    {
        if ($request->date) {
            $members = User::where('role', 'MEMBER')->get();
            foreach ($members as $member) {
                $attendance = new Attendance();
                $attendance->user_id = $member->id;
                $attendance->date = $request->date;
                $attendance->status = 'unattended';
                $attendance->save();
            }
        }
        return redirect()->route('attendance.index')->with('success', 'Date created successfully');
    }

    public function getMemberAttendances(Request $request)
    {
        $attendances = Attendance::where('user_id', $request->user_id)->get();
        $data = [];
        foreach ($attendances as $attendance) {
            $data[] = [
                'id' => $attendance->id,
                'date' => $attendance->date,
                'member' => $attendance->getUser->first_name . ' ' . $attendance->getUser->last_name,
                'status' => $attendance->status == 'attended' ? '<span class="badge bg-success">Present</span>' : '<span class="badge bg-danger">Absent</span>',
                'fine' => $attendance->status == 'attended' ? "--" : ($attendance->hasFine
                    ? ($attendance->hasFine->status == 'paid'
                        ? '<span class="text-success">Fine Paid</span>'
                        : '<span class="text-danger">Fined</span>')
                    : '<a class="btn btn-sm btn-primary give-fine-btn" data-id="' . $attendance->id . '">Give Fine</a>'),
            ];
        }
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $attendance = Attendance::findOrFail($request->id);
        $attendance->status = $request->status;
        $attendance->save();

        return response()->json(['success' => true]);
    }

    public function giveFine(Request $request)
    {
        $attendance = Attendance::findOrFail($request->id);
        $fine =  new Fine();
        $fine->user_id = $attendance->user_id;
        $fine->attendance_id = $attendance->id;
        $fine->amount = 100;
        $fine->save();

        return response()->json([
            'status' => true,
            'message' => 'Fined successfully'
        ]);
    }
}
