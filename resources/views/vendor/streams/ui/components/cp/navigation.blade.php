<!-- navigation.blade.php -->
<div class="c-sidebar__nav">
    <nav>

        @foreach ($cp->navigation()->filter(function($section) {
            return !$section->parent;
        }) as $section)
        
        @php
            $children = $cp->navigation()->children($section);
        @endphp

        {!! $section->link([
            'class' => ($section->active ? '-active' : '') . ($children->active() ? ' -has-active' : '')
        ]) !!}
    
        @if ($children->isNotEmpty())
        <ul>
            @foreach ($children as $child)
                <li class="{{ $child->active ? '-has-active' : '' }}">
                    {!! $child->link([
                        'class' => ($child->active ? '-active' : ''),
                    ]) !!}
                </li>
            @endforeach
        </ul>        
        @endif
    
        @endforeach
    </nav>    
</div>
