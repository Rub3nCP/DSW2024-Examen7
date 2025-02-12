<select name="theme_id">
  @foreach($themes as $theme)
      <option value="{{ $theme->id }}" {{ old('theme_id', $post->theme_id ?? '') == $theme->id ? 'selected' : '' }}>
          {{ $theme->name }}
      </option>
  @endforeach
</select>

