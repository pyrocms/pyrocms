<!-- multiselect.blade.php -->
<select {!! $input->htmlAttributes() !!}>
@foreach ($input->field->type()->options() as $key => $value)
    <option {{ in_array($key, (array) $input->value) ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
@endforeach
</select>
