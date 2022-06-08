<!-- avatar.blade.php -->
<div {!! $avatar->htmlAttributes() !!}>
    <div class="w-24 h-24 rounded">
        <img src="{{ $avatar->img }}"/>
    </div>
</div>
