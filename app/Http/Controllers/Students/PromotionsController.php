<?php

namespace App\Http\Controllers\students;

use  App\Models\grade;
use  App\Models\Students;
use App\Models\promotions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Grades = grade::all();
        return view('pages.Students.promotion.index', compact('Grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $promotions = promotions::all();
        return view('pages.Students.promotion.management', compact('promotions'));
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
        try {
            $Students = Students::where('Grade_id', $request->Grade_id)->where('Classroom_id', $request->Classroom_id)->where('section_id', $request->section_id)->where('academic_year', $request->academic_year)->get();




            foreach ($Students as $Student) {

                $ids = explode(',', $Student->id);

                Students::whereIn('id', $ids)->update([

                    'Grade_id' => $request->Grade_id_new,

                    'Classroom_id' => $request->Classroom_id_new,

                    'section_id' => $request->section_id_new,
                    'academic_year' => $request->academic_year_new,


                ]);

                promotions::updateOrCreate([
                    'student_id' => $Student->id,
                    'from_grade' => $request->Grade_id,
                    'from_Classroom' => $request->Classroom_id,
                    'from_section' => $request->section_id,
                    'to_grade' => $request->Grade_id_new,
                    'to_Classroom' => $request->Classroom_id_new,
                    'to_section' => $request->section_id_new,
                    'academic_year' => $request->academic_year,
                    'academic_year_new' => $request->academic_year_new,
                ]);
            }

            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
        }
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
    public function destroy(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            if ($request->page_id == 1) {
                $promotions = promotions::all();



                foreach ($promotions as $promotion) {
                    $ids = explode(',', $promotion->student_id);


                    Students::whereIn('id', $ids)->update([
                        'Grade_id' => $promotion->from_grade,
                        'Classroom_id' => $promotion->from_Classroom,
                        'section_id' => $promotion->from_section,
                        'academic_year' => $promotion->academic_year

                    ]);

                    promotions::truncate();
                }
                DB::commit();
                toastr()->error(trans('messages.Delete'));
                return redirect()->back();
            } else {

                $promotions = promotions::findorfail($request->id);

                Students::where('id', $promotions->student_id)->update([
                    'Grade_id'=>$promotions->from_grade,
                    'Classroom_id'=>$promotions->from_Classroom,
                    'section_id'=>$promotions->from_section,
                    'academic_year'=>$promotions->academic_year

                ]);

                promotions::destroy($request->id);
                DB::commit();
                toastr()->error(trans('messages.Delete'));
                return redirect()->back();

                
            }
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
