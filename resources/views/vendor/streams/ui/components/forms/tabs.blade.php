<!-- tabs.blade.php -->
<div class="c-tabs">

    <ul>
        @foreach ($section['tabs'] as $slug => $tab)
        <li>
            <button type="button" data-toggle="tab" class="{{ $loop->first ? 'active' : '' }}"
                data-target="#{{ $form->options->get('prefix') }}{{ \Illuminate\Support\Arr::get($tab, 'slug', $slug) }}-tab">
                {{ $tab['title'] }}
            </button>
        </li>
        @endforeach
    </ul>

    <div class="c-tabs__content">
        @foreach ($section['tabs'] as $slug => $tab)
        <div id="{{ $form->options->get('prefix') }}{{ Arr::get($tab, 'slug', $slug) }}-tab"
            class="tabs__pane {{ $loop->first ? 'active' : '' }}">
            @if (isset($tab['view']))
                @include($tab['view'])
            @elseif (isset($tab['html']))
                {!! View::parse($tab['html']) !!}
            @else
                @include('ui::components.forms.fields', ['fields' => $tab['fields']])
            @endif
        </div>
        @endforeach
    </div>

</div>
