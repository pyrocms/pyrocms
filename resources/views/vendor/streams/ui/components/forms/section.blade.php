<!-- section.blade.php -->
<div class="c-card">

    @include('ui::components.forms.header')

    @include('ui::components.forms.fields', ['fields' => $section['fields']])

</div>
