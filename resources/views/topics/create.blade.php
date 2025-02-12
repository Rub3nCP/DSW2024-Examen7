
<form action="{{ route('topics.store') }}" method="POST">
  @csrf
  <label for="name">Nombre del tema</label>
  <input type="text" id="name" name="name">
  <button type="submit">Crear tema</button>
</form>
