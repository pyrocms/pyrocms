@php
    $theme = Streams::repository('cp.themes')
        ->find(Config::get('streams.ui.cp_theme', 'default'));

    View::share('theme', $theme);
@endphp

@include('ui::components.cp.styles')

@yield('content')

@include('ui::components.cp.assets')
