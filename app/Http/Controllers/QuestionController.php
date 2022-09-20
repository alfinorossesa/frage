<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Http\Requests\ReportRequest;
use App\Models\Question;
use App\Models\Tag;
use App\Services\LeaderboardService;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $questionService;
    protected $leaderboardService;
    public function __construct(QuestionService $questionService, LeaderboardService $leaderboardService)
    {
        $this->questionService = $questionService;
        $this->leaderboardService = $leaderboardService;
    }

    public function index()
    {
        $questions = $this->questionService->questionFilter();
        $count = $this->questionService->questionCount();
        $leaderboard = $this->leaderboardService->leaderboard();
        $relatedTags = $this->questionService->relatedTags();

        $meta = [
            'url' => route('question.index'),
            'title' => 'All Question',
            'description' => "Help other people's question."
        ];

        return view('home.question.index', compact('questions', 'count', 'leaderboard', 'relatedTags', 'meta'));
    }

    public function askQuestion()
    {
        $mostUsedTags = $this->questionService->relatedTags();

        $meta = [
            'url' => route('question.askQuestion'),
            'title' => 'Ask Question',
            'description' => 'Ask everything on FRAGE.'
        ];

        return view('home.question.ask-question', compact('mostUsedTags', 'meta'));
    }

    public function askQuestionStore(AskQuestionRequest $request)
    { 
        $question = $this->questionService->storingAskQuestion($request);

        return redirect()->route('question.show', [$question->id, $question->slug]);
    }

    public function show(Question $question, $slug)
    {   
        $bestAnswerCheck = $question->hasBestAnswer($question);
        $question->incrementViewCount();

        $share = \Share::page(route('question.show', [$question->id, $question->slug]), $question->title)
                        ->facebook()
                        ->twitter()
                        ->getRawLinks();

        $leaderboard = $this->leaderboardService->leaderboard();
        $relatedTags = $this->questionService->relatedTags();
        $relatedQuestions = $this->questionService->relatedQuestions($question);

        $meta = [
            'url' => route('question.show', [$question->id, $question->slug]),
            'title' => $question->title,
            'description' => $question->excerpt
        ];
          
        return view('home.question.show', compact('question', 'bestAnswerCheck', 'share', 'leaderboard', 'relatedTags', 'relatedQuestions', 'meta'));
    }

    public function edit(Question $question, $slug)
    {
        $mostUsedTags = $this->questionService->relatedTags();

        $meta = [
            'url' => route('question.show', [$question->id, $question->slug]),
            'title' => $question->title,
            'description' => $question->excerpt
        ];

        return view('home.question.edit', compact('question', 'mostUsedTags', 'meta'));
    }

    public function update(Question $question, $slug, AskQuestionRequest $request)
    {
        $this->questionService->updatingQuestion($question, $request);

        return redirect()->route('question.show', [$question->id, $question->slug]);
    }

    public function votesCount(Question $question, Request $request)
    {  
        return $this->questionService->countingVotes($question, $request);
    }

    public function like(Question $question)
    { 
        return $this->questionService->updatingLikes($question);
    }

    public function destroy(Question $question, $slug)
    {
        foreach ($question['tag'] as $tag) {
            $tags = Tag::where('tag', $tag['tag'])->first();
            if ($tags->count > 1) {
                $tags->update([
                    'count' => $tags->count - 1
                ]);
            } else {
                $tags->delete();
            }
        }

        $this->questionService->deleteQuestionImage($question);
        $question->delete();

        return redirect()->route('question.index');
    }

    public function search(Request $request)
    {
        $questions = $this->questionService->searchQuestion($request);
        $count = $this->questionService->searchFilterQuestionCount($request);
        $leaderboard = $this->leaderboardService->leaderboard();
        $relatedTags = $this->questionService->relatedTags();

        $meta = [
            'url' => route('question.index'),
            'title' => 'Question',
            'description' => 'Question by search : '. $request->search
        ];

        return view('home.question.index', compact('questions', 'count', 'leaderboard', 'relatedTags', 'meta'));
    }

    public function report(Question $question, $slug)
    {
        $meta = [
            'url' => route('question.report', [$question, $slug]),
            'title' => 'Report Question',
            'description' => $question->excerpt
        ];

        return view('home.question.report', compact('question', 'meta'));
    }

    public function reportStore(Question $question, $slug, ReportRequest $request)
    {
        $report = $this->questionService->questionReport($question, $request);

        return redirect()->route('question.reportCallback', [$question->id, $question->slug, $report->id]);
    }

    public function reportCallback($question, $slug, $report)
    {
        $meta = [
            'url' => url('/'),
            'title' => 'Curious about something?',
            'description' => 'Ask everything on FRAGE.'
        ];

        return view('home.question.report-callback', compact('meta'));
    }
}
