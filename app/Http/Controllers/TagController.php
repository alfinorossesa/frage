<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\LeaderboardService;
use App\Services\QuestionService;
use App\Services\TagServices;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;
    protected $leaderboardService;
    protected $questionService;
    public function __construct(TagServices $tagService, LeaderboardService $leaderboardService, QuestionService $questionService)
    {
        $this->tagService = $tagService;
        $this->leaderboardService = $leaderboardService;
        $this->questionService = $questionService;
    }

    public function index()
    {
        $tags = Tag::latest()->paginate(20);

        $meta = [
            'url' => route('tag.index'),
            'title' => 'All Tags',
            'description' => 'Using the right tags makes it easier for others to find and answer your question.'
        ];

        return view('home.tag.index', compact('tags', 'meta'));
    }

    public function questionByTag(Tag $tag)
    {
        $questions = $this->tagService->questionFilter($tag);
        $count = $this->tagService->questionCount($tag);
        $leaderboard = $this->leaderboardService->leaderboard();
        $relatedTags = $this->questionService->relatedTags();

        $meta = [
            'url' => route('tag.questionByTag', $tag->tag),
            'title' => 'Question',
            'description' => 'Question by Tag : ' .$tag->tag
        ];
        
        return view('home.tag.question-by-tag', compact('tag', 'questions', 'count', 'leaderboard', 'relatedTags', 'meta'));
    }

    public function update(Tag $tag, Request $request)
    {
        return $this->tagService->updateTag($tag, $request);
    }

    public function destroy(Tag $tag)
    {   
        return $this->tagService->deleteTag($tag);
    }
}
