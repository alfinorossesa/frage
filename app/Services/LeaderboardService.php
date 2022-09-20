<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LeaderboardService
{
    public function leaderboard()
    {
        $users = DB::table('users')
                    ->join('answers', 'answers.user_id', '=', 'users.id')
                    ->join('best_answers', 'best_answers.answer_id', '=', 'answers.id')
                    ->where(function ($query) {
                        $query->where('check', 1);
                    })
                    ->select('users.id', 'users.name', 'users.username', 'users.picture', 'users.oauth_picture', 'best_answers.check', DB::raw('count(best_answers.check) as best_answer_count'))
                    ->groupBy('users.id')
                    ->orderByDesc('best_answer_count')
                    ->take(10)
                    ->get();

        $leaderboard = $users->map(function($item, $key){
            return [
                'id' => $item->id,
                'name' => $item->name,
                'username' => $item->username,
                'picture' => $item->picture,
                'oauth_picture' => $item->oauth_picture,
                'best_answer_count' => $item->best_answer_count,
                'rank' => $key + 1
            ];
        });

        return $leaderboard;
    }
}