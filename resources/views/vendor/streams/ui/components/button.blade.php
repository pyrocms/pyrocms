{!! $button->open() !!}
{{-- <i v-show="button.icon" :class="button.icon"></i> --}}
{{ __($button->text()) }}
@if (isset($button->attributes['data-keymap']))
    <span class="hud-only -keymap">{{ $button->attributes['data-keymap'] }}</span>
@endif
{!! $button->close() !!}
