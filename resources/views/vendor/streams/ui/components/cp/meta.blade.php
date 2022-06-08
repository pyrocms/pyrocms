<div class="c-sidebar__meta">
    <div class="text-white opacity-25 text-xs">
        {{ number_format(microtime(true) - Request::server('REQUEST_TIME_FLOAT'), 2) . ' s' }}&nbsp;|&nbsp;
        @php
        $size = memory_get_usage(true);

        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

        echo round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
        @endphp
    </div>
</div>
