<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ReportRequest;
use App\Models\Answer;
use App\Models\AnswerReport;
use App\Models\Question;
use App\Services\AnswerService;
use App\Services\LeaderboardService;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    protected $answerService;
    protected $leaderboardService;
    protected $questionService;
    public function __construct(AnswerService $answerService, LeaderboardService $leaderboardService, QuestionService $questionService)
    {
        $this->answerService = $answerService;
        $this->leaderboardService = $leaderboardService;
        $this->questionService = $questionService;
    }

    public function store(Question $question, AnswerRequest $request)
    {
        $this->answerService->storingAnswer($question, $request);
        
        return redirect()->route('question.show', [$question->id, $question->slug]);
    }

    public function edit($question, $slug, Answer $answer)
    {
        $relatedQuestions = $this->questionService->relatedQuestions($answer->question);

        $meta = [
            'url' => route('question.show', [$answer->question->id, $answer->question->slug]),
            'title' => $answer->question->title,
            'description' => $answer->excerpt
        ];

        return view('home.answer.edit', compact('answer', 'relatedQuestions', 'meta'));
    }

    public function update($question, $slug, Answer $answer, AnswerRequest $request)
    {
        $this->answerService->updatingAnswer($answer, $request);

        return redirect()->route('question.show', [$answer->question->id, $answer->question->slug]);
    }
    
    public function commentStore(Answer $answer, CommentRequest $request)
    {   
        $this->answerService->storingComment($answer, $request);
        
        return response()->json([
            'user' => $answer->user,
            'comment' => $request->comment,
            'count' => $answer->answerComment->count() +1
        ], 200);
    }
    
    public function answerComment(Question $question, $slug, Answer $answer)
    {
        $bestAnswerCheck = $question->hasBestAnswer($question);
        $leaderboard = $this->leaderboardService->leaderboard();
        $relatedQuestions = $this->questionService->relatedQuestions($question);

        $meta = [
            'url' => route('answer.allComment', [$question, $slug, $answer]),
            'title' => $answer->question->title,
            'description' => $answer->excerpt
        ];

        return view('home.answer.comment', compact('answer', 'bestAnswerCheck', 'leaderboard', 'relatedQuestions', 'meta'));
    }

    public function votesCount(Answer $answer, Request $request)
    {  
        return $this->answerService->countingVotes($answer, $request);
    }

    public function like(Answer $answer)
    {
        return $this->answerService->updatingLikes($answer);
    }

    public function bestAnswer(Answer $answer)
    {
        $this->answerService->markAsBestAnswer($answer);

        return response()->json('check', 200);
    }

    public function destroy(Answer $answer)
    {   
        // delete answer image on storage
        $this->answerService->deleteAnswerImage($answer);

        $answer->delete();
        
        return response()->json([
            'answer_id' => $answer->id,
            'answer_count' => $answer->where('question_id', $answer->question->id)->count()
        ], 200);
    }

    public function report(Answer $answer)
    {
        $meta = [
            'url' => route('answer.report', $answer->id),
            'title' => 'Report Answer',
            'description' => $answer->excerpt
        ];

        return view('home.answer.report', compact('answer', 'meta'));
    }

    public function reportStore(Answer $answer, ReportRequest $request)
    {
        $report = $this->answerService->storingReport($answer, $request);

        return redirect()->route('answer.reportCallback', [$answer->id, $report->id]);
    }

    public function reportCallback($answer, $report)
    {
        $meta = [
            'url' => url('/'),
            'title' => 'Curious about something?',
            'description' => 'Ask everything on FRAGE.'
        ];

        return view('home.answer.report-callback', compact('meta'));
    }
}
