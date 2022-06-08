{{-- partials.metadata --}}
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="{{ config('app.locale') }}">

<meta name="generator" content="Laravel Streams"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="description" content="{{ config('app.description') }}"/>

{!! View::includes('meta') !!}

<title>
    {{ config('app.name') }}
    @if (isset($metaTitle))
        &#8250;
        {{ $metaTitle }}
    @endif
</title>

<link rel="icon" type="image/png" href="/img/favicon.png"/>

{{-- @include('streams::partials.constants') --}}

{!! View::includes('head') !!}

{!! Assets::tag('/css/theme.css') !!}
