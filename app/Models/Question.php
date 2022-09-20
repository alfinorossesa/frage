<?php

namespace App\Models;

use App\Traits\HasBestAnswer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, HasBestAnswer;

    protected $guarded = ['id'];
    protected $casts = [
        'tag' => 'array',
        ];

    public function incrementViewCount() {
        if ((auth()->user()->id ?? null) !== $this->user_id) {
            $this->view_count++;
        }

        return $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answer()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function bestAnswer()
    {
        return $this->hasMany(BestAnswer::class, 'question_id');
    }

    public function questionVotes()
    {
        return $this->hasMany(QuestionVotes::class, 'question_id');
    }

    public function questionLike()
    {
        return $this->hasMany(QuestionLike::class, 'question_id');
    }

    public function questionReport()
    {
        return $this->hasMany(QuestionReport::class, 'question_id');
    }
}
