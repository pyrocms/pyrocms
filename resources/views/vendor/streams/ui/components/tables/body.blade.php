<?php
/** @var \Streams\Ui\Table\Table $table */
?>

<!-- body.blade.php -->
{{ $table->view }}
<tbody>
    @section('rows')
    @foreach ($table->rows as $row)
    <tr {!! $row->htmlAttributes() !!}>

        <td class="hidden">
            <input type="hidden" name="{{ $table->prefix('row[]') }}" value="{{ $row->key }}" />
        </td>

        @if ($table->selectable)
        <td class="c-table__selector">
            <input type="checkbox" name="{{ $table->prefix('selected[]') }}" value="{{ $row->key }}" />
        </td>
        @endif

        @foreach ($row->columns as $column)
        <td {!! $column->htmlAttributes() !!}>{!! $column->value !!}</td>
        @endforeach

        <td class="c-table__buttons">
            <nav class="c-buttons">
            {!! $row->buttons->map->render()->implode('') !!}
            </nav>
        </td>

    </tr>
    @endforeach
    @show
</tbody>
