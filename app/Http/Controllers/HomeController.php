<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $meta = [
            'url' => url('/'),
            'title' => 'Curious about something?',
            'description' => 'Ask everything on FRAGE.'
        ];

        return view('home.index', compact('meta'));
    }
}
