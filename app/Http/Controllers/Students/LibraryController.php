<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Models\Library;
use App\Models\grade;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = Library::all();
        return view('pages.library.index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grades = grade::all();
        return view('pages.library.create',compact('grades'));
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
            //code...

            $Library = new Library();

            $Library->title = $request->title;
            $Library->Grade_id = $request->Grade_id;
            $Library->Classroom_id = $request->Classroom_id;
            $Library->section_id = $request->section_id;
            $Library->teacher_id = 1;

            $file = $request->file('file_name');

            $filename = $file->getClientOriginalName();

            $fileextension = $file->getClientOriginalExtension();

            $Library->file_name = $filename;
          

            $file->storeAs('attachments/library/'.$filename,$filename,'upload_attachment');

            $Library->save();

            return redirect()->route('library.index');

        } catch (\Throwable $th) {
            //throw $th;
        }

        return $request->file('file_name')->getClientOriginalName();
    }


    public function downloadAttachments($bookname)
    {
        
        return response()->download(public_path('assets/attachments/library/'.$bookname.'/'.$bookname));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show(Library $library)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $grades = grade::all();
        $book = library::findorFail($id);
        return view('pages.library.edit',compact('book','grades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            $book = library::findorFail($request->id);
            $book->title = $request->title;

            if($request->hasfile('file_name')){

                $this->deleteFile($book->file_name);

                $this->uploadFile($request,'file_name');

                $file_name_new = $request->file('file_name')->getClientOriginalName();
                $book->file_name = $book->file_name !== $file_name_new ? $file_name_new : $book->file_name;
            }

            $book->Grade_id = $request->Grade_id;
            $book->classroom_id = $request->Classroom_id;
            $book->section_id = $request->section_id;
            $book->teacher_id = 1;
            $book->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('library.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Storage::disk('upload_attachment')->delete(public_path('assets/attachments/library/'.$request->file_name.'/'.$request->file_name));
        library::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('library.index');
    }
}
