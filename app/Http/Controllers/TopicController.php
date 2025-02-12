<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        return view('topics.index', compact('topics'));
    }

    public function create()
    {
        return view('topics.create');
    }

    public function store(Request $request)
    {
        $topic = new Topic();
        $topic->name = $request->input('name');
        $topic->save();
        return redirect()->route('topics.index');
    }
    
    public function posts($id)
    {
        $topic = Topic::find($id);
        $posts = $topic->posts;
        return view('topics.posts', compact('posts', 'topic'));
    }
}