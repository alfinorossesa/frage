<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['user', 'answerLike', 'answerVotes', 'answerComment', 'answerReport'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answerVotes()
    {
        return $this->hasMany(AnswerVotes::class, 'answer_id');
    }

    public function answerLike()
    {
        return $this->hasMany(AnswerLike::class, 'answer_id');
    }

    public function answerComment()
    {
        return $this->hasMany(AnswerComment::class, 'answer_id');
    }

    public function bestAnswer()
    {
        return $this->hasMany(BestAnswer::class, 'answer_id');
    }

    public function answerReport()
    {
        return $this->hasMany(AnswerReport::class, 'answer_id');
    }
}
