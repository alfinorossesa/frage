<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index()
    {
        $meta = [
            'url' => route('login'),
            'title' => 'Login',
            'description' => 'Ask everything on FRAGE.'
        ];

        return view('auth.login.index', compact('meta'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect(RouteServiceProvider::HOME);
        }
            
        throw ValidationException::withMessages([
            'email' => 'Your credentials do not match',
        ]);
    }
}
