<label for="{{ $id }}" class="text-xs text-center bg-theme-sub mt-2">{{ $label }}</label>
<input type="text" id="{{ $id }}" name="{{ $id }}" class="text-sm py-0" value="{{ session($id) }}" autocomplete="off">