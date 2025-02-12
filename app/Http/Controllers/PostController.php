<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Theme;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Auth::user()->posts;
        $themes = Theme::all(); 
        return view('posts.index', compact('posts', 'themes')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    public function read(int $id)
    {
        $post = Post::find($id);
        return view('posts.read', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:posts|min:3|max:255',
            'summary' => 'max:2000',
            'body' => 'required',
            'published_at' => 'required|date',
        ]);
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $validated['title'];
        $post->summary = $validated['summary'];
        $post->body = $validated['body'];
        $post->published_at = $validated['published_at'];
        $post->save();
        
        return redirect()->route('posts.index')
    ->with('success', 'Publicación creada correctamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $post = Post::findOrFail($id);

    if ($post->user_id !== Auth::id()) {
        return redirect()->route('posts.index')
            ->with('error', 'No puedes editar una publicación de la que no eres el autor.');
    }

    return view('posts.edit', compact('post'));
}

public function update(Request $request, Post $post)
{
    if ($post->user_id !== Auth::id()) {
        return redirect()->route('posts.index')
            ->with('error', 'No puedes actualizar una publicación de la que no eres el autor.');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'summary' => 'nullable|string|max:500',
        'body' => 'required|string',
        'published_at' => 'required|date',
    ]);

    $post->update($validated);

    return redirect()->route('posts.index')->with('success', 'Publicación actualizada con éxito');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id == Auth::id()) {
            $post->delete();
            return redirect()->route('posts.index')
                    ->with('success', 'Publicación eliminada correctamente.');
        } else {
            return redirect()->route('posts.index')
                    ->with('error', 'No puedes eliminar una publicación de la que no eres el autor.');
        }      
    }


    public function vote(Post $post) {

        $vote = $post->votedUsers()->find(Auth::id());
        if (!$vote) {
        $post->votedUsers()->attach(Auth::id());

        } else {
        $post->votedUsers()->detach(Auth::id());
        }
        return redirect()->back();
    }

    public function home() {
    $query = Post::select('id', 'title', 'summary', 'published_at', 'user_id')
    ->where('published_at', '<=', \Carbon\Carbon::today())
    ->orderByDesc('published_at');


    $firstPosts = $query->take(5)
        ->get();


    $otherPosts = $query->skip(5)
        ->take(20)
        ->get();    

        return view('home', compact('firstPosts', 'otherPosts'));
    }

    public function changeTheme(Request $request)
    {
        $themeId = $request->input('theme_id');
        $theme = Theme::find($themeId);
        $request->session()->put('theme', $theme);
        return redirect()->back();
    }
}