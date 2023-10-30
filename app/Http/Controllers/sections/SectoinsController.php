<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;

use App\Models\sectoins;
use App\Models\grade;
use App\Models\Classroom;
use App\Models\Teacher;

use Illuminate\Http\Request;

class SectoinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $Grades = grade::with(['sections'])->get();

        $list_Grades = grade::all();

        $Teachers = Teacher::all();





        return view('pages.sections.sections',compact('Grades','list_Grades','Teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


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

        $sectoins = new sectoins();

        $sectoins->Name_Section = ['ar'=>$request->Name_Section_Ar , 'en'=>$request->Name_Section_En];
        $sectoins->Status = 1;
        $sectoins->Grade_id = $request->Grade_id;
        $sectoins->Class_id = $request->Class_id;

        $sectoins->save();

        $sectoins->teachers()->attach($request->teacher_id);





        toastr()->success( trans('message.success'));
        return redirect()->route('Sections.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sectoins  $sectoins
     * @return \Illuminate\Http\Response
     */
    public function show(sectoins $sectoins)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sectoins  $sectoins
     * @return \Illuminate\Http\Response
     */
    public function edit(sectoins $sectoins)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sectoins  $sectoins
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //


        try {


            $sectoins = sectoins::findorfail($request->id);

            $status_value = 1;

            if(isset($request->Status))
            {
                $status_value = 1;

            }
            else
            {
                $status_value = 2;

            }



            $sectoins->Status = $status_value;
            $sectoins->Name_Section = ['en' => $request->Name_Section_En, 'ar' => $request->Name_Section_Ar];
            $sectoins->Grade_id = $request->Grade_id;
            $sectoins->Class_id = $request->Class_id;
             $sectoins->Status =$status_value;

             if(isset($request->teacher_id))
             {
                 $sectoins->teachers()->sync($request->teacher_id);
             }
             else
             {
                 $sectoins->teachers()->sync(array());
             }

             $sectoins->save();




            toastr()->success( trans('message.Update'));
            return redirect()->route('Sections.index');





        } catch (\Exception $e) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sectoins  $sectoins
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        $id = $request->id;

        $grage = sectoins::findOrFail($id)->delete();

        toastr()->warning( trans('message.Delete'));
        return redirect()->route('Sections.index');
    }


    public function ahmed($id)
    {
        $list_classes = Classroom::where('Grade_id',$id)->pluck("Name_class","id");



        return $list_classes;
    }
}
