<?php

namespace App\Http\Controllers\Grade;
use  App\Http\Controllers\Controller;

use App\Models\grade;
use App\Models\Classroom;
use Illuminate\Http\Request;

use App\Events\welcomeUser;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $grades =grade::all();

        return view('pages.grades.Grade',compact('grades'));
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
       /* $validatedData = $request->validate([
           // 'Name' => 'required|unique:grade|max:255',
          //  'Notes' => 'required',
        ]);*/



        if(grade::where('Name->en',$request->Name_en)->orwhere('Name->ar',$request->Name)->exists())
        {
            return redirect()->route('Grades.index')->withErrors(trans('validation.unique'));
        }

         /*$request->validate([
             'Name' => 'required|unique:grades,Name->ar'.$this->id,
             'Name_en'=>'required|unique:grades,Name->en'.$this->id
         ]);
*/


       $grade = new grade();

        $grade->Name = ['en' => $request->Name_en, 'ar' => $request->Name];
        $grade->Notes = $request->Notes;

        $grade->save();


        // كدة انا ندهت علي ال event بتاعي

        event(new welcomeUser($grade));

        toastr()->success( trans('message.success'));
        return redirect()->route('Grades.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        try {

           /* $Grades = grade::findorfail($request->id);

            $Grades->update([

                $Grades->Name = ['en' => $request->Name_en, 'ar' => $request->Name],

                $Grades->Notes = $request->Notes,
            ]);*/

    

            $Grades = grade::where('id',$request->id)->first();
     

            $Grades->update([

                $Grades->Name = ['en' => $request->Name_en, 'ar' => $request->Name],

                $Grades->Notes = $request->Notes,
            ]);


            toastr()->success( trans('message.Update'));
            return redirect()->route('Grades.index');




        } catch (\Exception $e) {
            //throw $th;

            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //


        try {
     //Classroom

            $Classroom = Classroom::where('Grade_id','=',$request->id);

            if($Classroom->count() == 0)
            {
                $id = $request->id;

                $grage = grade::findOrFail($id)->delete();

                toastr()->warning( trans('message.Delete'));
                return redirect()->route('Grades.index');
            }
            else
            {
                toastr()->error(trans('message.delete_exception') );
                return redirect()->route('Grades.index');
            }





        }
        catch (\Exception $e) {
            //throw $th;
        }


    }
}
