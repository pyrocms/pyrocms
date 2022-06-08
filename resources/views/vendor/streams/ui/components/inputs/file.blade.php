<!-- file.blade.php -->
<input {!! $input->htmlAttributes() !!}>

@if ($input->value)
    <input {!! $input->htmlAttributes([
        'type' => 'text',
        'class' => 'mt-4',
        'readonly' => true,
        'name' => $input->name(),
        'value' => $input->value,
    ]) !!}>
@endif
