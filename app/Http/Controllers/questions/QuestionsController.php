<?php

namespace App\Http\Controllers\questions;

use App\Http\Controllers\Controller;

use App\Models\Questions;
use App\Models\Quizze;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function store(Request $request)
    {
        try {
            $question = new Questions();
            $question->title = $request->title;
            $question->answers = $request->answers;
            $question->right_answer = $request->right_answer;
            $question->score = $request->score;
            $question->quizze_id = $request->quizz_id;
            $question->save();
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        $quizz_id = $id;
        return view('pages.Teachers.dashboard.Questions.create', compact('quizz_id'));
    }


    public function edit($id)
    {
        $question = Questions::findorFail($id);
        return view('pages.Teachers.dashboard.Questions.edit', compact('question'));
    }


    public function update(Request $request, $id)
    {
        try {
            $question = Questions::findorfail($id);
            $question->title = $request->title;
            $question->answers = $request->answers;
            $question->right_answer = $request->right_answer;
            $question->score = $request->score;
            $question->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            Questions::destroy($id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
