<!-- form.blade.php -->
<div class="c-form" x-data="{}">
    
    {!! $form->open([
        //'x-data' => "app.get('form')({$form->toJson()})",
        //'x-init' => 'init()'
    ]) !!}

    @include('ui::components.forms.layout')
    @include('ui::components.forms.controls')
    
    {!! $form->close() !!}

</div>
