<?php

namespace App\Http\Controllers\Teacher;

use  App\Http\Controllers\controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Teacher;
use App\Models\Specialization;
use App\Models\Gender;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $Teachers = Teacher::all();

        return view('pages.Teachers.Teachers',compact('Teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $specializations = Specialization::all();
       $genders  =  Gender::all();

        return view('pages.Teachers.create',compact('specializations','genders'));
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

        $request->validate([
            'Email' => 'required|unique:teachers,Email',
            'Password' => 'required',
            'Name_ar' => 'required',
            'Name_en' => 'required',
            'Specialization_id' => 'required',
            'Gender_id' => 'required',
            'Joining_Date' => 'required|date|date_format:Y-m-d',
            'Address' => 'required',

        ]);

        try {
            $Teachers = new Teacher();
            $Teachers->email = $request->Email;
            $Teachers->password =  Hash::make($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('Teachers.create');
        }
        catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modesl\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modesl\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Teachers = Teacher::findorfail($id);
        $specializations = Specialization::all();
        $genders  =  Gender::all();
        return view('pages.Teachers.edit',compact('Teachers','specializations','genders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modesl\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        try {
            $Teachers = Teacher::findOrFail($request->id);
            $Teachers->email = $request->Email;
            $Teachers->password =  Hash::make($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;

            $Teachers->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Teachers.index');
        }
        catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modesl\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = $request->id;

        Teacher::findorfail($id)->delete();

        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Teachers.index');


    }
}
