<!-- top.blade.php -->
<div class="o-cp__topbar">
    <div class="c-topbar">

        <div class="c-topbar__buttons" x-data="{}">
            {!! $cp->buttons()->collect()->map->render()->implode('') !!}
        </div>

        @include('ui::components.cp.shortcuts')

    </div>
</div>
