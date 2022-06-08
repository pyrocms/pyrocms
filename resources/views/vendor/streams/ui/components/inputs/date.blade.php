
<input {!! $input->htmlAttributes([
    'value' => $input->value ? $input->value->format('Y-m-d') : null
]) !!}>
