<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();
        
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->username = Str::slug($data->name, '-');
            $user->email = $data->email;
            $user->oauth = 'google';
            $user->oauth_picture = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        
        $this->_registerOrLoginUser($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
