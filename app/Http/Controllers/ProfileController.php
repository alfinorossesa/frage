<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\User;
use App\Services\LeaderboardService;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    protected $leaderboardService;
    protected $profileService;
    public function __construct(LeaderboardService $leaderboardService, ProfileService $profileService)
    {
        $this->leaderboardService = $leaderboardService;
        $this->profileService = $profileService;
    }

    public function index(User $user, $username)
    {
        $reach = $this->profileService->reach($user);
        $topQuestion = $user->question->sortByDesc('vote')->take(10);
        $topAnswer = $user->answer->sortByDesc('vote')->take(10);
        $leaderboard = $this->leaderboardService->leaderboard()->where('id', $user->id)->first();

        $meta = [
            'url' => route('user.index', [$user, $username]),
            'title' => $user->name,
            'description' => 'Profile'
        ];
        
        return view('home.profile.index', compact('user', 'reach', 'topQuestion', 'topAnswer', 'leaderboard', 'meta'));
    }

    public function updateProfile(User $user, $username)
    {
        $meta = [
            'url' => route('user.index', [$user, $username]),
            'title' => $user->name,
            'description' => 'Profile'
        ];

        return view('home.profile.update-profile', compact('user', 'meta'));
    }

    public function updateProfileStore(User $user, $username, UpdateProfileRequest $request)
    {
        $this->profileService->updatingProfile($user, $request);

        return redirect()->route('user.index', [$user->id, $user->username]);
    }

    public function changePassword(User $user, $username)
    {
        $meta = [
            'url' => route('user.index', [$user, $username]),
            'title' => $user->name,
            'description' => 'Profile'
        ];

        return view('home.profile.change-password', compact('user', 'meta'));
    }

    public function changePasswordStore(User $user, $username, ChangePasswordRequest $request)
    {
        if (Hash::check($request->old_password, $user->password)) {
            $user->update($request->only('password'));

            return redirect()->route('user.index', [$user->id, $username]);
        }

        throw ValidationException::withMessages([
            'old_password' => 'Old password do not match'
        ]);

    }

    public function activity(User $user, $username)
    {
        $meta = [
            'url' => route('user.activity', [$user, $username]),
            'title' => $user->name,
            'description' => 'Summary'
        ];

        return view('home.profile.activity', compact('user', 'meta'));
    }

    public function question(User $user, $username)
    {
        $questions = $user->question()->latest()->paginate(20);

        $meta = [
            'url' => route('user.question', [$user, $username]),
            'title' => $user->name,
            'description' => 'Question'
        ];

        return view('home.profile.question', compact('user', 'questions', 'meta'));
    }

    public function answer(User $user, $username)
    {
        $answers = $user->answer()->latest()->paginate(20);

        $meta = [
            'url' => route('user.answer', [$user, $username]),
            'title' => $user->name,
            'description' => 'Answer'
        ];

        return view('home.profile.answer', compact('user', 'answers', 'meta'));
    }

    public function comment(User $user, $username)
    {
        $comments = $user->answerComment()->latest()->paginate(20);

        $meta = [
            'url' => route('user.comment', [$user, $username]),
            'title' => $user->name,
            'description' => 'Comment'
        ];

        return view('home.profile.comment', compact('user', 'comments', 'meta'));
    }
    
    public function votes(User $user, $username)
    {
        $questionVotesUp = $user->questionVotes()->where('option', 'votes-up')->latest()->paginate(20);
        $questionVotesDown = $user->questionVotes()->where('option', 'votes-down')->latest()->paginate(20);

        $answerVotesUp = $user->answerVotes()->where('option', 'votes-up')->latest()->paginate(20);
        $answerVotesDown = $user->answerVotes()->where('option', 'votes-down')->latest()->paginate(20);

        $meta = [
            'url' => route('user.votes', [$user, $username]),
            'title' => $user->name,
            'description' => 'Votes'
        ];

        return view('home.profile.votes', compact('user', 'questionVotesUp', 'questionVotesDown', 'answerVotesUp', 'answerVotesDown', 'meta'));
    }

    public function likesQuestion(User $user, $username)
    {
        $likesQuestion = $user->questionLike()->where('status', true)->latest()->paginate(20);

        $meta = [
            'url' => route('user.likesQuestion', [$user, $username]),
            'title' => $user->name,
            'description' => 'Likes Question'
        ];

        return view('home.profile.likes-question', compact('user', 'likesQuestion', 'meta'));
    }

    public function likesAnswer(User $user, $username)
    {
        $likesAnswer = $user->answerLike()->where('status', true)->latest()->paginate(20);

        $meta = [
            'url' => route('user.likesAnswer', [$user, $username]),
            'title' => $user->name,
            'description' => 'Likes Answer'
        ];

        return view('home.profile.likes-answer', compact('user', 'likesAnswer', 'meta'));
    }
}
