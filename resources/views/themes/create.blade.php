<form action="{{ route('themes.store') }}" method="POST">
  @csrf
  <input type="text" name="name" placeholder="Nuevo Tema" required>
  <button type="submit">Crear Tema</button>
  <x-button.secondary @click="cancel()">Cancelar</x-button>
    <x-button.primary type="submit">Crear</x-button>
</form>
