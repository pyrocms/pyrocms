<!-- styles.blade.php -->
{{ Assets::load('styles', 'ui::css/variables.css') }}
{{ Assets::load('styles', 'ui::css/theme.css') }}

{{ Assets::load('styles', 'ui::css/tailwind.css') }}

{!! Assets::collection('styles')->tags() !!}

@if (isset($theme))
<style>{dd('Test')}
    :root {
        @php

            $styles = array_filter([
                '--ui-spacing' => $theme->spacing,
                '--ui-radius' => $theme->radius,
                
                '--ui-color-light' => $theme->light,
                '--ui-color-dark' => $theme->dark,
                
                '--ui-color-black' => $theme->black,
                '--ui-color-white' => $theme->white,
                
                '--ui-color-primary' => $theme->primary,
                '--ui-color-secondary' => $theme->secondary,
                
                '--ui-color-text' => $theme->text,
                '--ui-color-buttons' => $theme->buttons,
            ]);

        @endphp

        @foreach ($styles as $key => $value)
        {{ $key }}: {{ $value }};
        @endforeach
    }
</style>
@endif
