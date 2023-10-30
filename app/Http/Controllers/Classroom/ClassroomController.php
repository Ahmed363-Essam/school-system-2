<?php

namespace App\Http\Controllers\Classroom;

use  App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Classroom;
use App\Models\grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $Classrooms = Classroom::all();

    $grades = grade::all();

    return view('pages.classes.my_classes',compact('Classrooms','grades'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {

    /*$request->validate([
        'Name' => 'required',
        'Name_class_en' => 'required',
        'Grade_id'=>'required'

    ],
    [
        'Name.required'=> trans('validation.required'),
        'Name_class_en.required'=>trans('validation.required'),
        'Grade_id.required'=>trans('validation.required')
    ]);*/


    $validatedData = $request->validate([
        'List_Classes.*.Name' => 'required',
        'List_Classes.*.Name_class_en' => 'required',
     ],
    [
        'Name.required'=>trans('validation.required'),
        'Name.Name_class_en'=>trans('validation.required')
    ]);

try {



    $List_Classes = $request->List_Classes1;



    foreach($List_Classes as $List_Classe)
    {
        $Classrooms = new Classroom();

        $Classrooms->Name_Class = ['en' => $List_Classe['Name_class_en'] , 'ar'=> $List_Classe['Name']];

        $Classrooms->Grade_id = $List_Classe['Grade_id'];

        $Classrooms->save();

    }



    toastr()->success( trans('message.success'));
    return redirect()->route('classes.index');

} catch (\Exception $e) {

    return redirect()->back()->withErrors(['errors'=>$e->getMessage()]);


}

    /*$List_Classes  =  $request->List_Classes;

    foreach($List_Classes as $List_Classe)
    {
        return $List_Classe['Name'];
    }*/
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request)
  {


    $id = $request->id;

    $Classrooms =  Classroom::findorfail($id);

    $Classrooms->update([
        $Classrooms->Grade_id  = $request->Grade_id,

        $Classrooms->Name_Class = ['ar'=>$request->Name , 'en'=> $request->Name_en]

    ]);


    toastr()->success( trans('message.Update'));
    return redirect()->route('classes.index');


  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request)
  {
    $id = $request->id;

    $Classroom = Classroom::findorfail($id)->delete();
    toastr()->error('تم الحذف بنجاح');
    return redirect()->route('classes.index');
  }

  public function delete_all(Request $request)
  {
    $delete_all_id = explode(',',$request->delete_all_id());

    Classroom::whereIn('id','=',$delete_all_id)->delete();

    toastr()->warning( trans('message.Delete'));
    return redirect()->route('classes.index');


  }


  public function Filter_Classes(Request $request)
  {

    $grades = grade::all();
         $search = Classroom::where('Grade_id','=',$request->Grade_id)->get();
    return view('pages.classes.my_classes',compact('grades'))->withDetails('search');
  }

}

?>
