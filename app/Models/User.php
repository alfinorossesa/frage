<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function question()
    {
        return $this->hasMany(Question::class, 'user_id');
    }

    public function questionVotes()
    {
        return $this->hasMany(QuestionVotes::class, 'user_id');
    }

    public function questionLike()
    {
        return $this->hasMany(QuestionLike::class, 'user_id');
    }

    public function questionReport()
    {
        return $this->hasMany(QuestionReport::class, 'user_id');
    }

    public function answer()
    {
        return $this->hasMany(Answer::class, 'user_id');
    }

    public function answerVotes()
    {
        return $this->hasMany(AnswerVotes::class, 'user_id');
    }

    public function answerLike()
    {
        return $this->hasMany(AnswerLike::class, 'user_id');
    }

    public function answerComment()
    {
        return $this->hasMany(AnswerComment::class, 'user_id');
    }

    public function answerReport()
    {
        return $this->hasMany(AnswerReport::class, 'user_id');
    }


}
