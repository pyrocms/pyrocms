<!-- head.blade.php -->
<thead>
    <tr>

        <!-- ID Spacer -->
        <th class="hidden"></th>
        
        @if ($table->selectable)
        <th class="c-table__selector">
        <input type="checkbox" x-on:click="alert('Toggle all');">
        </th>
        @endif

        @foreach ($table->columns as $column)
        <th {!! $column->htmlAttributes() !!}>

            @if ($column->isSortable())
            <a href="{{ $column->href() }}">
                {!! __($column->heading()) !!}
                @if ($column->direction() == 'asc')
                @svg('heroicon-o-sort-ascending')
                @elseif ($column->direction() == 'desc')
                @svg('heroicon-o-sort-descending')
                @else
                @svg('heroicon-o-switch-vertical')
                @endif
            </a>
            @else
            {!! __($column->heading()) !!}
            @endif
        </th>
        @endforeach

        <!-- Buttons Spacer -->
        <th></th>

    </tr>
</thead>
