<div class="c-dropdown" x-data="{show: false}">

    {{-- {!! $dropdown->button([
        'x-on:click' => 'show == true ? show = false : show = true; return false;',
        'x-on:click.away' => 'show = false',
    ])->open() !!} --}}
    
    @if ($dropdown->svg)
    {!! $dropdown->svg !!}
    @endif

    @if ($dropdown->icon)
    {{-- <x-{{ $dropdown->icon }}/> --}}
    @endif

    {{-- <span>{{ __($dropdown->text()) }}</span> --}}

    {{-- {!! $dropdown->close() !!} --}}
    
    <div class="c-dropdown__content" x-show="show">
        <div>
            {{-- @foreach ($dropdown->dropdown as $item)
            <a {!! Html::attributes($item['attributes']) !!}><span>{{ $item['text'] }}</span></a>
            @endforeach --}}
        </div>
    </div>

</div>
