<!-- content.blade.php -->
<div class="o-cp__content">
    @if (isset($__default))
        {!! $__default !!}
    @else
        @yield('content')
    @endif
</div>
