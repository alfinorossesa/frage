<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\AnswerReport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AnswerService
{
    public function summernote($request)
    {
        $answer = $request->answer;
        $dom = new \DomDocument();
    
        $dom->loadHtml($answer, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); 
        $images = $dom->getElementsByTagName('img');

        foreach($images as $k => $img){
            $data = $img->getattribute('src');
            if (strpos($data, 'data:image') !== false){
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $image_name = time().rand(000,999).$k.'.png';
                $path = public_path().'/assets/question/answer-image/'. $image_name;
                $path2 = '/assets/question/answer-image/'. $image_name;
                file_put_contents($path, $data);
                $img->removeattribute('src');
                $img->setattribute('src', $path2);
            }
        }
    
        return $dom->saveHTML();
    }

    public function summernoteUpdate($answer, $request)
    {
        $body = $request->answer;
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
                $path = public_path().'/assets/question/answer-image/'. $image_name;
                $path2 = '/assets/question/answer-image/'. $image_name;
                file_put_contents($path, $data);
                $img->removeattribute('src');
                $img->setattribute('src', $path2);
            }
        }

        foreach ($this->getImageFromAnswerBody($answer) as $value) {
            if (!in_array($value, $oldImages))
            {
                File::delete(str_replace("/assets","assets", $value));
            }
        }
       
        return $dom->saveHTML();
    }

    public function getImageFromAnswerBody($answer)
    {
        $body = $answer->answer;
        $dom = new \DomDocument();
    
        @$dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); 
        $images = $dom->getElementsByTagName('img');
        $answerImages = [];
        foreach($images as $img){
            $answerImages[] = $img->getattribute('src');
        }

        return $answerImages;
    }

    public function deleteAnswerImage($answer)
    {
        $body = $answer->answer;
        $dom = new \DomDocument();
    
        @$dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); 
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            File::delete(str_replace("/assets","assets", $img->getattribute('src')));
        }
        
        return $dom->saveHTML();
    }

    public function storingAnswer($question, $request)
    {
        $answer = $this->summernote($request);
        
        $createAnswer = Answer::create([
            'user_id' => auth()->user()->id ?? null,
            'question_id' => $question->id,
            'name' => auth()->user()->name ?? $request->name,
            'email' => auth()->user()->email ?? $request->email,
            'answer' => $answer,
            'excerpt' => Str::limit(strip_tags($request->answer), 50)
        ]);

        return $createAnswer;
    }

    public function updatingAnswer($answer, $request)
    {
        $answerInput = $this->summernoteUpdate($answer, $request);
        
        $update = $answer->update([
            'answer' => $answerInput,
            'excerpt' => Str::limit(strip_tags($request->answer), 50)
        ]);

        return $update;
    }

    public function markAsBestAnswer($answer)
    {
        if ($answer->bestAnswer()->first() !== null) {
            $check = $answer->bestAnswer()->where('answer_id', $answer->id)->first()['check'] == 1 ? false : true;
        } else {
            $check = true;
        }
        
        $bestAnswer = $answer->bestAnswer()->updateOrCreate([
                            'question_id' => $answer->question->id,
                            'answer_id' => $answer->id
                        ],
                        [
                            'check' => $check
                        ]);

        return $bestAnswer;
    }

    public function countingVotes($answer, $request)
    {
        $count = $answer->vote;
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
        
        $answer->update([
            'vote' => $count
        ]);

        if ($answer->answerVotes->where('user_id', auth()->user()->id)->first() !== null) {
            $status = $answer->answerVotes->where('user_id', auth()->user()->id)->first()['status'] == 1 ? false : true;
            $option = $status == false ? null : $request->option;
        } else {
            $status = true;
            $option = $request->option;
        }

        $answer->answerVotes()->updateOrCreate([
            'answer_id' => $answer->id,
            'user_id' => auth()->user()->id
        ],
        [
            'status' => $status,
            'option' => $option
        ]);
        
        return response()->json([
            'status' => $status,
            'count' => $count
        ], 200);
    }

    public function storingComment($answer, $request)
    {
        $comment = $answer->answerComment()->create([
            'answer_id' => $answer->id,
            'user_id' => auth()->user()->id,
            'comment' => $request->comment
        ]);

        return $comment;
    }

    public function updatingLikes($answer)
    {
        if ($answer->answerLike->where('user_id', auth()->user()->id)->first() !== null) {
            $status = $answer->answerLike->where('user_id', auth()->user()->id)->first()['status'] == 1 ? false : true;
        } else {
            $status = true;
        }


        $answer->answerLike()->updateOrCreate([
            'user_id' => auth()->user()->id,
            'answer_id' => $answer->id
        ],
        [
            'status' => $status
        ]);
        
        return response()->json('success', 200);
    }

    public function storingReport($answer, $request)
    {
        $report = AnswerReport::create([
            'answer_id' => $answer->id,
            'user_id' => auth()->user()->id,
            'report_message' => $request->report_message
        ]);

        return $report;
    }
}