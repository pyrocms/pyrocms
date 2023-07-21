<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Language" content="{{ config('app.locale') }}">
<title>
    {{ config('app.name') }}
    @if (isset($metaTitle))
        &#8250;
        {{ $metaTitle }}
    @endif
</title>
<link rel="stylesheet" href="css/styles.css">

<link rel="icon" type="image/png" href="/img/favicon.png"/>
