<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class DataQuestionController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->get();

        return view('admin.data-question.index', compact('questions'));
    }

    public function show(Question $question)
    {
        return view('admin.data-question.show', compact('question'));
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('dataQuestion.index')->with('destroy', 'Question deleted!');
    }
}
