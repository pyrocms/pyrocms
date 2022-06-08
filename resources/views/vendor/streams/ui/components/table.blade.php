<div class="c-table">

    @include('ui::components.tables.views')
    @include('ui::components.tables.filters')

    @if ($table->rows->isNotEmpty())

    {!! Form::open([
        'url' => $table->url(),
    ]) !!}

        <div class="c-table__content">
            <table {!! $table->htmlAttributes() !!}>

                @include('ui::components.tables.head')
                @include('ui::components.tables.body')
                @include('ui::components.tables.foot')
                
            </table>
        </div>

    {!! Form::close() !!}
    
    @else

    <div class="c-table__content --empty p-4">
        {{ trans('ui::messages.no_results') }}
    </div>

    @endif
</div>
