<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Question;
use Illuminate\Http\Request;

class DataTagsController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->get();

        return view('admin.data-tags.index', compact('tags'));
    }

    public function show(Tag $tag)
    {
        $questions = Question::where('tag', 'LIKE', '%' . $tag->tag . '%')->latest()->get();
        
        return view('admin.data-tags.show', compact('tag', 'questions'));
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('dataTags.index')->with('destroy', 'Tag deleted!');
    }
}
