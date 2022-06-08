<!-- radio.blade.php -->
@foreach ($input->field->type()->options() as $key => $value)
<label class="inline-flex items-center">
    <input {!! $input->htmlAttributes([
        'value' => $key,
        $input->value == $key ? 'checked' : null,
    ]) !!}/> 
    <span class="ml-2 dark:text-white">{{ $value }}</span>
</label><br>
@endforeach
