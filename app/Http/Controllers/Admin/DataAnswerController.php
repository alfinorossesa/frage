<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;

class DataAnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::latest()->get();

        return view('admin.data-answer.index', compact('answers'));
    }

    public function show(Answer $answer)
    {
        return view('admin.data-answer.show', compact('answer'));
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();

        return redirect()->route('dataAnswer.index')->with('destroy', 'Answer deleted!');
    }
}
