<h1>Listado de Temas</h1>

<ul>
    @foreach($themes as $theme)
        <li>{{ $theme->name }} ({{ $theme->posts->count() }} publicaciones)</li>
    @endforeach
</ul>