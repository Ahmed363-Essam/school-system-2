<?php

namespace App\Http\Controllers\Students;
use App\Models\grade;
use App\Models\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GraduatedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $students = Students::onlyTrashed()->get();
        return view('pages.Students.Graduated.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Grades = grade::all();
        return view('pages.Students.Graduated.create',compact('Grades'));
    }

    public function softDelete(Request $request)
    {


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
        $students = Students::where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id )->where('section_id',$request->section_id)->get();

        foreach($students as $student)
        {
            $ids = explode(',',$student->id);

            Students::whereIn('id',$ids)->Delete();
        }

        toastr()->success(trans('messages.success'));

        return redirect()->route('Graduated.index');
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
    public function update(Request $request)
    {
        //
        Students::onlyTrashed()->where('id',$request->id)->restore();

        toastr()->success(trans('messages.success'));
        return redirect()->route('Graduated.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request )
    {
        //
        $id = $request->id;

        Students::onlyTrashed()->where('id',$id)->forceDelete();

        
        toastr()->success(trans('messages.success'));

        return redirect()->route('Graduated.index');
    }
}
