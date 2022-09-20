<?php

namespace App\Http\Controllers;

use App\Services\LeaderboardService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    protected $leaderboardService;
    public function __construct(LeaderboardService $leaderboardService)
    {
        $this->leaderboardService = $leaderboardService;
    }

    public function index()
    {
        $leaderboard = $this->leaderboardService->leaderboard();

        $meta = [
            'url' => route('leaderboard.index'),
            'title' => 'Leaderboard',
            'description' => 'Leaderboard rank user by help other question and get best answer mark.'
        ];

        return view('home.leaderboard.index', compact('leaderboard', 'meta'));
    }
}
