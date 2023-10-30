<?php

namespace App\Http\Controllers\Parents\dashboard;

use App\Http\Controllers\Controller;
use App\Models\parents;
use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Attendance;

class ChildrenController extends Controller
{
    //

    public function index()
    {
        $sons =Students::where('parent_id',auth('parent')->user()->id)->get();

         return view('pages.parents.dashboard',compact('sons'));

    }

    
    public function children()
    {
        $students =Students::where('parent_id',auth('parent')->user()->id)->get();

         return view('pages.parents.children.index',compact('students'));

    }

    public function attendences()
    {
        $students =Students::where('parent_id',auth('parent')->user()->id)->get();


   

         return view('pages.parents.Attendance.index',compact('students'));

    }

    public function attendanceSearch(Request $request)
    {
        $students =Students::where('parent_id',auth('parent')->user()->id)->get();
        if($request->student_id ==0)
        {
           $Students = Attendance::whereBetween('attendence_date',[$request->from,$request->from])->get();

           return view('pages.parents.Attendance.index',compact('Students','students'));
        }
        else
        {
            $Students = Attendance::whereBetween('attendence_date',[$request->from,$request->from])->where('student_id',$request->student_id)->get();
            return view('pages.parents.Attendance.index',compact('Students','students'));
        }
    }

}
