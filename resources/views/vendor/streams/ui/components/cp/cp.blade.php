<!doctype html>
<html lang="en">

@php
    $theme = Streams::repository('cp.themes')
        ->find(Config::get('streams.ui.cp_theme', 'default'));

    $theme = $theme ?: Streams::entries('cp.themes')->first();
    
    View::share('theme', $theme);
@endphp

<head>
    @include('ui::components.cp.head')
</head>

<body>
    
    <div class="o-cp {{ isset($theme) ? $theme->brand_mode : null }}">

        @if (isset($sidebar))
            {!! $sidebar !!}
        @else
            @include('ui::components.cp.sidebar')
        @endif

        <div class="o-cp__main">
            @include('ui::components.cp.top')
            @include('ui::components.cp.content')
        </div>

    </div>

    @include('ui::components.cp.assets')
    @include('ui::components.cp.messages')

    {{-- @include('ui::components.cp.surfaces') --}}
    @include('ui::components.cp.modals')

</body>

</html>
