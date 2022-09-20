<?php

namespace App\Traits;

trait HasBestAnswer
{
    public function hasBestAnswer($question)
    {
        $answer = $question->answer()->with('bestAnswer')->has('bestAnswer')->get()->toArray();
        
        $bestAnswer = [];
        foreach ($answer as $value) {
            $bestAnswer[] = $value['best_answer'][0]['check'];
        }
    
        return in_array(1, $bestAnswer);
    }
}