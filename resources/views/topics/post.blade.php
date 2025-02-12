<h1>Publicaciones del tema {{ $topic->name }}</h1>
<ul>
    @foreach($posts as $post)
        <li>{{ $post->title }}</li>
    @endforeach
</ul>