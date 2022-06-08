<!-- time.blade.php -->
<input {!! $input->htmlAttributes([
    'value' => $input->value ? $input->value->format('H:i') : null
]) !!}/>
