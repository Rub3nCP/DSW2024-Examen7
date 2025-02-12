
<h1>Listado de temas</h1>
<ul>
    @foreach($topics as $topic)
        <li>{{ $topic->name }} ({{ $topic->posts->count() }} publicaciones)</li>
    @endforeach
</ul>
