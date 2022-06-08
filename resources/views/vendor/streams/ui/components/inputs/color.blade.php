<!-- color.blade.php -->
<input {!! $input->htmlAttributes([
    'type' => 'color',
]) !!} {{-- oninput="document.documentComponent.style.setProperty('--color-primary', this.value);" --}}>
