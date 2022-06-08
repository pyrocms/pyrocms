<!-- fields.blade.php -->
<div class="c-form__fields">
@foreach ($fields->fields as $field => $config)
@include('ui::forms.field', ['field' => $fields->stream->fields->get($field)])
@endforeach
</div>
