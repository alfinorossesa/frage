<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionReport;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class QuestionService
{
    public function summernote($request)
    {
        $body = $request->body;
        $dom = new \DomDocument();
    
        @$dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); 
        $images = $dom->getElementsByTagName('img');

        foreach($images as $k => $img){
            $data = $img->getattribute('src');
            if (strpos($data, 'data:image') !== false){
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $image_name = time().rand(000,999).$k.'.png';
                $path = public_path().'/assets/question/upload-image/'. $image_name;
                $path2 = '/assets/question/upload-image/'. $image_name;
                file_put_contents($path, $data);
                $img->removeattribute('src');
                $img->setattribute('src', $path2);
            }
        }
    
        return $dom->saveHTML();
    }
    
    public function summernoteUpdate($question, $request)
    {
        $body = $request->body;
        $dom = new \DomDocument();
    
        @$dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); 
        $images = $dom->getElementsByTagName('img');

        $oldImages = [];
        foreach($images as $k => $img){
            $oldImages[] = $img->getattribute('src');
            $data = $img->getattribute('src');
            if (strpos($data, 'data:image') !== false){
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $image_name = time().rand(000,999).$k.'.png';
                $path = public_path().'/assets/question/upload-image/'. $image_name;
                $path2 = '/assets/question/upload-image/'. $image_name;
                file_put_contents($path, $data);
                $img->removeattribute('src');
                $img->setattribute('src', $path2);
            }
        }

        foreach ($this->getImageFromQuestionBody($question) as $value) {
            if (!in_array($value, $oldImages))
            {
                File::delete(str_replace("/assets","assets", $value));
            }
        }
       
        return $dom->saveHTML();
    }

    public function getImageFromQuestionBody($question)
    {
        $body = $question->body;
        $dom = new \DomDocument();
    
        @$dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); 
        $images = $dom->getElementsByTagName('img');
        $questionImages = [];
        foreach($images as $img){
            $questionImages[] = $img->getattribute('src');
        }

        return $questionImages;
    }

    public function deleteQuestionImage($question)
    {
        $body = $question->body;
        $dom = new \DomDocument();
    
        @$dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); 
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            File::delete(str_replace("/assets","assets", $img->getattribute('src')));
        }
        
        return $dom->saveHTML();
    }

    public function storingAskQuestion($request)
    {
        $tags = [];
        foreach ($request->tag as $value) {
            $tag = Tag::query();
            if ($tag->where('tag', $value)->first() == null) {
                $tag->create([
                    'tag' => $value,
                    'count' => 1
                ]);
            } else {
                $tagCount = $tag->where('tag', $value)->first();
                $tag->update([
                    'count' => $tagCount->count += 1
                ]);
            }
            
            $tags[] = [
                'tag' => strtolower($value) 
            ];
        }

        $body = $this->summernote($request);

        $question = Question::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'body' => $body,
            'excerpt' => Str::limit(strip_tags($request->body), 275),
            'tag' => $tags
        ]);

        return $question;
    }

    public function updatingQuestion($question, $request)
    {
        $tags = [];
        foreach ($request->tag as $value) {
            $tag = Tag::query();
            if ($tag->where('tag', $value)->first() == null) {
                $tag->create([
                    'tag' => $value,
                    'count' => 1
                ]);
            } 
            
            $tags[] = [
                'tag' => strtolower($value) 
            ];
        }

        $body = $this->summernoteUpdate($question, $request);

        $update = $question->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'body' => $body,
            'excerpt' => Str::limit(strip_tags($request->body), 275),
            'tag' => $tags
        ]);

        return $update;
    }

    public function countingVotes($question, $request)
    {
        $count = $question->vote;
        if ($request->option == 'votes-up') {
            if ($request->vote == 0) {
                $count += 1;
            } else {
                $count -= 1;
            }
        } else {
            if ($request->vote == 0) {
                $count -= 1;
            } else {
                $count += 1;
            }
        }
        
        $question->update([
            'vote' => $count
        ]);

        if ($question->questionVotes->where('user_id', auth()->user()->id)->first() !== null) {
            $status = $question->questionVotes->where('user_id', auth()->user()->id)->first()['status'] == 1 ? false : true;
            $option = $status == false ? null : $request->option;
        } else {
            $status = true;
            $option = $request->option;
        }

        $question->questionVotes()->updateOrCreate([
            'question_id' => $question->id,
            'user_id' => auth()->user()->id,
        ],
        [
            'status' => $status,
            'option' => $option
        ]);
        
        return response()->json([
            'status' => $status,
            'count' => $count,
            'option' => $option
        ], 200);
    }

    public function updatingLikes($question)
    {
        if ($question->questionLike->where('user_id', auth()->user()->id)->first() !== null) {
            $status = $question->questionLike->where('user_id', auth()->user()->id)->first()['status'] == 1 ? false : true;
        } else {
            $status = true;
        }

        $question->questionLike()->updateOrCreate([
            'user_id' => auth()->user()->id,
            'question_id' => $question->id,
        ],
        [
            'status' => $status
        ]);
        
        return response()->json('success', 200);
    }

    public function questionFilter()
    {
        $questionModel = Question::query(); 

        if (request()->has('mostPopular')) {
            $questions = $questionModel->with(['answer', 'user'])->orderBy('view_count', 'desc')->paginate(20);
        }

        if (request()->has('unanswered')) {
            $questions = $questionModel->with(['answer', 'user'])->doesnthave('answer')->latest()->paginate(20);
        } else {
            $questions = $questionModel->with(['answer', 'user'])->latest()->paginate(20);
        }

        return $questions;
    }

    public function questionCount()
    {
        $questionModel = Question::with(['answer', 'user'])->get(); 

        if (request()->has('unsolved')) {
            $questions = [];
            foreach ($questionModel as $question) {
                if ($question->hasBestAnswer($question) == false){
                    $questions[] = $question;
                }
            }
            $count = count($questions);
        } elseif (request()->has('solved')) {
            $questions = [];
            foreach ($questionModel as $question) {
                if ($question->hasBestAnswer($question)){
                    $questions[] = $question;
                }
            }
            $count = count($questions);
        } else {
            $count = $this->questionFilter()->total();
        }

        return $count;
    }

    public function searchQuestion($request)
    {
        $questionModel = Question::query(); 
        $search = $request->search;

        if (request()->has('search') && request()->has('mostPopular')) {
            $questions = $questionModel->with(['answer', 'user'])
                                        ->where('questions.title', 'like', '%' .$search. '%')
                                        ->orWhere('questions.body', 'like', '%' .$search. '%')
                                        ->orderBy('view_count', 'desc')->paginate(20)->withQueryString();
        }

        if (request()->has('search') && request()->has('unanswered')) {
            $questions = $questionModel->with(['answer', 'user'])->doesnthave('answer')
                                        ->where(function($q) use($search){
                                            $q->where('questions.title', 'like', '%' .$search. '%')
                                                ->orWhere('questions.body', 'like', '%' .$search. '%');
                                        })
                                        ->latest()->paginate(20)->withQueryString();
        } else {
            $questions = $questionModel->with(['answer', 'user'])
                                        ->where('questions.title', 'like', '%' .$search. '%')
                                        ->orWhere('questions.body', 'like', '%' .$search. '%')
                                        ->latest()->paginate(20)->withQueryString();
        }

        return $questions;
    }

    public function searchFilterQuestionCount($request)
    {
        $search = $request->search;
        $questionModel = Question::with(['answer', 'user'])
                                    ->where('questions.title', 'like', '%' .$search. '%')
                                    ->orWhere('questions.body', 'like', '%' .$search. '%')
                                    ->get();

        if (request()->has('unsolved')) {
            $questions = [];
            foreach ($questionModel as $question) {
                if ($question->hasBestAnswer($question) == false){
                    $questions[] = $question;
                }
            }
            $count = count($questions);
        } elseif (request()->has('solved')) {
            $questions = [];
            foreach ($questionModel as $question) {
                if ($question->hasBestAnswer($question)){
                    $questions[] = $question;
                }
            }
            $count = count($questions);
        } else {
            $count = $this->searchQuestion($request)->total();
        }

        return $count;
    }

    public function questionReport($question, $request)
    {
        $report = QuestionReport::create([
            'question_id' => $question->id,
            'user_id' => auth()->user()->id,
            'report_message' => $request->report_message
        ]);

        return $report;
    }

    public function relatedTags()
    {
        $tags = Tag::orderBy('count', 'desc')->get()->take(10);

        return $tags;
    }

    public function relatedQuestions($question)
    {
        $questions = Question::where('id', '!=', $question->id)->orderBy('view_count', 'desc')->get()->take(10);

        return $questions;
    }
}