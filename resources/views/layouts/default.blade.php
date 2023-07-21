<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials/head')
</head>

<body>
    @include('partials/header')

    <main id="{{ str_replace('/', '-', Request::path() ?: 'homepage') }}">
        @yield('content')
    </main>

    @include('partials/footer')
    @include('partials/assets')
</body>

</html>
