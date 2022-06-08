<!-- toggle.blade.php -->
<div x-data="{checked: {{ json_encode($input->value) }}}">

    <input {!! $input->htmlAttributes([
        'class' => 'hidden',
        'value' => null,
        'checked' => ($input->value),
    ]) !!} x-model="checked">
    
    <div class="toggle" x-on:click="checked == true ? checked = false : checked = true;" x-bind:class="{ 
        'on' : checked,
        'off' : !checked,
      }">
        <div class="toggle-pill"></div>
    </div>
    
</div>
