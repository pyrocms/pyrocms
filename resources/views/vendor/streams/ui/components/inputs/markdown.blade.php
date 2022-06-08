<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
 
<div x-data="{
    init() {
        let editor = new SimpleMDE({ element: this.$refs.editor })
 
        editor.value(this.value)
 
        editor.codemirror.on('change', () => {
            this.value = editor.value()
        })
    },
}" class="prose">

    <textarea {!! $input->htmlAttributes([
        'x-ref' => 'editor',
        ]) !!}>{{ $input->value }}</textarea>

</div>
