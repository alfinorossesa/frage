<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\AnswerReport;
use App\Models\User;
use App\Models\Question;
use App\Models\QuestionReport;
use App\Models\Tag;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = User::where('isAdmin', true)->get();
        $user = User::where('isAdmin', false)->get();
        $question = Question::all();
        $answer = Answer::all();
        $tag = Tag::all();
        $questionReport = QuestionReport::all();
        $answerReport = AnswerReport::all();

        return view('admin.index', compact('admin', 'user', 'question', 'answer', 'tag', 'questionReport', 'answerReport'));
    }
}
