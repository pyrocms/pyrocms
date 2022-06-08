@if ($form->sections()->isnotEmpty())
    @foreach ($form->sections as $section)
        @if (isset($section['view']))
            @include($section['view'])
        @elseif (isset($section['html']))
            {!! View::parse($section['html']) !!}
        @elseif (isset($section['tabs']))
            @include('ui::components.forms.tabs')
        @else
            @include('ui::components.forms.section')
        @endif
    @endforeach
@else
    @include('ui::components.forms.default')
@endif
