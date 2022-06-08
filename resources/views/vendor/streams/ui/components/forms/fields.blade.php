<!-- fields.blade.php -->
<div class="c-form__fields">
@foreach ($fields as $field)
@include('ui::components.forms.field', ['field' => $field])
@endforeach
</div>
