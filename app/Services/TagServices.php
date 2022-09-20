<?php

namespace App\Services;

use App\Models\Question;

class TagServices
{
    public function questionFilter($tag)
    {
        $questionModel = Question::query(); 

        if (request()->has('mostPopular')) {
            $questions = $questionModel->where('tag', 'LIKE', '%' . $tag->tag . '%')->orderBy('view_count', 'desc')->paginate(20);
        }

        if (request()->has('unanswered')) {
            $questions = $questionModel->doesnthave('answer')->where('tag', 'LIKE', '%' . $tag->tag . '%')->latest()->paginate(20);
        } else {
            $questions = $questionModel->where('tag', 'LIKE', '%' . $tag->tag . '%')->latest()->paginate(20);
        }
        
        return $questions;
    }

    public function questionCount($tag)
    {
        if (request()->has('unsolved')) {
            $questions = [];
            foreach ($this->questionFilter($tag) as $question) {
                if ($question->hasBestAnswer($question) == false){
                    $questions[] = $question;
                }
            }
            $count = count($questions);
        } elseif (request()->has('solved')) {
            $questions = [];
            foreach ($this->questionFilter($tag) as $question) {
                if ($question->hasBestAnswer($question)){
                    $questions[] = $question;
                }
            }
            $count = count($questions);
        } else {
            $count = $this->questionFilter($tag)->total();
        }

        return $count;
    }

    public function updateTag($tag, $request)
    {
        if ($tag->tag === strtolower($request->tag)) {
            $tag->update([
                'count' => $tag->count + 1
            ]);
        }

        return response()->json('success', 200);
    }

    public function deleteTag($tag)
    {
        if ($tag->count > 1) {
            $tag->update([
                'count' => $tag->count - 1
            ]);
        } else {
            $tag->delete();
        }

        return response()->json('success', 200);
    }
}