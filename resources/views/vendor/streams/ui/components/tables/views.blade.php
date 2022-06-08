<!-- views.blade.php -->
@if ($table->views()->isNotEmpty())
<nav class="c-table__views">
    @foreach ($table->views()->all() as $view)
        <a {!! $view->htmlAttributes() !!}>
            {{ __($view->text()) }}
        </a>
    @endforeach
</nav>
@endif
