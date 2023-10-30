<?php

namespace App\Http\Controllers\Teacher\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\sectoins;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{

    public function index()
    {

        // section id of the teachhr
        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('sectoins_id');

        $students = Students::whereIn('section_id', $ids)->get();

        return view('pages.Teachers.dashboard.students.index', compact('students'));
    }

    public function section()
    {
        $sections_ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('sectoins_id');

        $sections = sectoins::with('Grades')->whereIn('id', $sections_ids)->get();


        return  view('pages.Teachers.dashboard.sections.index', compact('sections'));
    }

    public function attendance(Request $request)
    {



        try {

            $attenddate = date('Y-m-d');
            foreach ($request->attendences as $studentid => $attendence) {

                if ($attendence == 'presence') {
                    $attendence_status = true;
                } else if ($attendence == 'absent') {
                    $attendence_status = false;
                }

                Attendance::updateorCreate([
                    'student_id' => $studentid,
                    'attendence_date' => $attenddate
                ], 
                [
                    'student_id' => $studentid,
                    'grade_id' => $request->grade_id,
                    'classroom_id' => $request->classroom_id,
                    'section_id' => $request->section_id,
                    'teacher_id' => 1,
                    'attendence_date' => $attenddate,
                    'attendence_status' => $attendence_status
                ]);
            }
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAttendance(Request $request)
    {
        try {
            $date = date('Y-m-d');
            $student_id = Attendance::where('attendence_date', $date)->where('student_id', $request->id)->first();
            if ($request->attendences == 'presence') {
                $attendence_status = true;
            } else if ($request->attendences == 'absent') {
                $attendence_status = false;
            }
            $student_id->update([
                'attendence_status' => $attendence_status
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function attendanceReport()
    {
        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('sectoins_id');
        $students = Students::whereIn('section_id', $ids)->get();
        return view('pages.Teachers.dashboard.students.attendance_report', compact('students'));
    }

    public function attendanceSearch(Request $request)
    {


        $ids = DB::table('teacher_section')->where('teacher_id', auth()->user()->id)->pluck('sectoins_id');
        $students = Students::whereIn('section_id', $ids)->get();

        if ($request->student_id == 0) {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->get();
            return view('pages.Teachers.dashboard.students.attendance_report', compact('Students', 'students'));
        } else {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
            return view('pages.Teachers.dashboard.students.attendance_report', compact('Students', 'students'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
