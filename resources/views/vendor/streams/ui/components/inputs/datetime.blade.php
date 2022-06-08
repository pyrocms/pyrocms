<!-- datetime.blade.php -->
<input {!! $input->htmlAttributes([
    'value' => $input->value ? $input->value->format('Y-m-d\TH:i:s') : null
]) !!}/>
