<!-- decimal.blade.php -->
<input {!! $input->htmlAttributes([
    'step' => Arr::get($input->field->config, 'step', 0.1)
]) !!}>
