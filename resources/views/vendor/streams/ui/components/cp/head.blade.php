<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
{{-- <title>{{ config('app.name') }} | {{ $item->linkTitle ? $item->linkTitle : $item->title}}</title> --}}
<title>{{ config('app.name') }}</title>
<meta name="robots" content="noindex, follow" />
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="cf-2fa-verify" content="5491995f81e49ae">

<!-- Favicon -->
{{-- {!! favicons('public::img/favicon.png') !!} --}}
<link rel="icon" type="image/png" href="/vendor/streams/ui/img/favicon.png"/>
{!! Assets::collection('head.scripts')->tags() !!}

@include('ui::components.cp.styles')
