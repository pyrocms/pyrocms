<!-- slug.blade.php -->
<div x-data="{value: '{{ $input->value }}'}">

    <input {!! $input->htmlAttributes() !!}    
    x-model="value"
    x-on:keyup="value = String(value)
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-_]+/g,'')
        // Collapse dashes
        .replace(/-+/g, '-');">

</div>
