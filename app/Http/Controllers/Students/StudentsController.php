<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;

use App\Models\Students;

use App\Models\Gender;
use App\Models\Nationality;
use App\Models\sectoins;
use App\Models\grade;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\Type_Blood;
use App\Models\Classroom;
use App\Models\parents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $students  = Students::all();

        return view('pages.Students.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $Genders = Gender::all();
        $nationals = Nationality::all();
        $bloods  = Type_Blood::all();
        $my_classes = grade::all();
        $parents = parents::all();
        return view('pages.Students.add',compact('Genders','nationals','bloods','my_classes','parents'));





    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

       $request->validate([
            'email'=>'required|unique:students,email',
            'name_ar'=>'required'
        ]);



            $students = new Students();
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->gender_id = $request->gender_id;
            $students->nationalitie_id = $request->nationalitie_id;
            $students->blood_id = $request->blood_id;
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();


           foreach( $request->file('photos')  as $file)
           {
                $filename = $file->getClientOriginalName();

                $file->storeAs('attachments/students/'.$students->name,$file->getClientOriginalName(),'upload_attachment');

                $Image = new Image();

                $Image->filename = $filename;
                $Image->imageable_id = $students->id;
                $Image->imageable_type = "App\Models\Students";

                $Image->save();

           }

           DB::commit();



           toastr()->success(trans('messages.success'));
            return redirect()->route('Students.create');
        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Student = Students::findorfail($id);
        return view('pages.Students.show',compact('Student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $Students  = Students::findorfail($id);

        $Genders = Gender::all();

        $nationals = Nationality::all();
        $bloods  = Type_Blood::all();
        $Grades  = grade::all();
        $parents  = parents::all();
        return view('pages.Students.edit',compact('Students','Genders','nationals','bloods','Grades','parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

       $Students = Students::findorfail($request->id);

       $Students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
       $Students->email = $request->email;
       $Students->password = Hash::make($request->password);
       $Students->gender_id = $request->gender_id;
       $Students->nationalitie_id = $request->nationalitie_id;
       $Students->blood_id = $request->blood_id;
       $Students->Date_Birth = $request->Date_Birth;
       $Students->Grade_id = $request->Grade_id;
       $Students->Classroom_id = $request->Classroom_id;
       $Students->section_id = $request->section_id;
       $Students->parent_id = $request->parent_id;
       $Students->academic_year = $request->academic_year;

       $Students->save();

       return redirect()->route('Students.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //


        Students::findorfail($request->id)->delete();

        return redirect()->route('Students.index');
    }

    public function Get_classrooms($id)
    {
        $Classroom = Classroom::where('Grade_id',$id)->pluck('Name_Class','id');

        return $Classroom;
    }

    public function Get_Sections($id)
    {
        $list_sections = sectoins::where('Class_id',$id)->pluck('Name_Section','id');

        return $list_sections;
    }


    public function Upload_attachment(Request $request)
    {


        $student_name = $request->student_name;

        foreach($request->file('photos') as $file )
        {


            $filename = $file->getClientOriginalName();

            $file->storeAs('attachments/students/'.$student_name,$file->getClientOriginalName(),'upload_attachment');

            $Image = new Image();

            $Image->filename =$filename;
            $Image->imageable_id = $request->student_id;
            $Image->imageable_type = 'App\Models\Students';

            $Image->save();

        }

        toastr()->success(trans('messages.success'));

        return redirect()->route('Students.index');

    }


    public function Download_attachment($studentsname,$filename)
    {

        return response()->download(public_path('assets/attachments/students/'.$studentsname.'/'.$filename));

    }


    public function Delete_attachment(Request $request)
    {
        Storage::disk('upload_attachment')->delete('assets/attachments/students/'.$request->student_name.'/'.$request->filename);

        Image::findorfail($request->id)->delete();

        toastr()->success(trans('messages.success'));

        return redirect()->route('Students.index');

    }
}
