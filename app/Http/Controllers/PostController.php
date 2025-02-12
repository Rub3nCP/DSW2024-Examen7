<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos las publicaciones del usuario logueado
        $posts = Auth::user()->posts;
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtenemos todos los temas para poder seleccionar uno al crear la publicación
        $topics = Topic::all();
        return view('posts.create', compact('topics'));
    }

    /**
     * Show a specific post.
     */
    public function read(int $id)
    {
        $post = Post::findOrFail($id); // Mejor usar findOrFail para manejar casos de publicación no encontrada
        return view('posts.read', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $validated = $request->validate([
            'title' => 'required|unique:posts|min:3|max:255',
            'summary' => 'max:2000',
            'body' => 'required',
            'published_at' => 'required|date|before_or_equal:today',  // Validación de fecha
        ]);

        // Creamos una nueva publicación
        $post = new Post();
        $post->user_id = Auth::id(); // Asociamos al usuario logueado
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
    public function edit(Post $post)
    {
        // Verificamos si el usuario es dueño de la publicación
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'No puedes editar una publicación que no es tuya.');
        }
        
        // Obtenemos todos los temas disponibles para editar la publicación
        $topics = Topic::all();
        
        // Retornamos la vista con la publicación y los temas
        return view('posts.edit', compact('post', 'topics'));
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Verificamos si el usuario es dueño de la publicación
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'No puedes modificar esta publicación');
        }

        // Validación de los datos
        $validated = $request->validate([
            'title' => 'required|min:3|max:255|unique:posts,title,' . $post->id,  // Validación de título
            'summary' => 'max:2000',
            'body' => 'required',
            'published_at' => 'required|date|before_or_equal:today',  // Validación de fecha
        ]);

        // Actualizamos la publicación con los nuevos datos
        $post->title = $validated['title'];
        $post->summary = $validated['summary'];
        $post->body = $validated['body'];
        $post->published_at = $validated['published_at'];
        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Publicación actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Este método está omitiendo la ruta de eliminar en las rutas si no se necesita
    // Pero si la necesitas, puedes mantenerlo
    public function destroy(Post $post)
    {
        if ($post->user_id == Auth::id()) {
            $post->delete();
            return redirect()->route('posts.index')
                ->with('success', 'Publicación eliminada correctamente.');
        } else {
            return redirect()->route('posts.index')
                ->with('error', 'No puedes eliminar una publicación que no es tuya.');
        }      
    }

    /**
     * Votar por una publicación.
     */
    public function vote(Post $post)
    {
        $vote = $post->votedUsers()->find(Auth::id());
        if (!$vote) {
            $post->votedUsers()->attach(Auth::id());
        } else {
            $post->votedUsers()->detach(Auth::id());
        }
        return redirect()->back();
    }

    /**
     * Página de inicio mostrando las publicaciones más recientes.
     */
    public function home()
    {
        $query = Post::select('id', 'title', 'summary', 'published_at', 'user_id')
            ->where('published_at', '<=', \Carbon\Carbon::today())
            ->orderByDesc('published_at');

        $firstPosts = $query->take(5)->get(); // Las primeras 5 publicaciones
        $otherPosts = $query->skip(5)->take(20)->get(); // El resto de publicaciones

        return view('home', compact('firstPosts', 'otherPosts'));
    }
}
