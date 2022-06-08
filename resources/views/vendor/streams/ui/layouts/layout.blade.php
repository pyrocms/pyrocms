@foreach ($layout->content ?: [] as $content)
    {!! $content->map->render()->implode('') !!}
@endforeach
