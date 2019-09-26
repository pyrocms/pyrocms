<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pyro</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="39px" height="50px" viewBox="0 0 39 50" enable-background="new 0 0 39 50" xml:space="preserve">
                    <g id="Forum">
                        <g id="list-desktop" transform="translate(-155.000000, -25.000000)">
                            <g id="header">
                                <g id="header-contnet" transform="translate(155.000000, 25.000000)">
                                    <g id="Logo">
                                        <path id="Combined-Shape" fill="#656B6F" d="M9.373,0.097L26.094,0c1.597-0.009,3.109,0.693,4.133,1.908l0.157,0.196
                                            l7.68,10.035c0.416,0.544,0.7,1.176,0.832,1.849c0.457,2.337-1.01,4.605-3.298,5.167L35.387,19.2l-1.943,0.379l1.881,3.27
                                            c1.243,2.164,0.497,4.927-1.667,6.171c-0.458,0.264-0.96,0.445-1.481,0.535l-6.305,1.092c-0.334,0.059-0.557,0.375-0.5,0.709
                                            c0.012,0.062,0.031,0.122,0.061,0.178l6.327,12.164c0.429,0.826,0.108,1.844-0.718,2.273c-0.084,0.043-0.17,0.079-0.26,0.107
                                            l-11.795,3.81c-1.081,0.349-2.25-0.173-2.712-1.21L0.182,12.559c-0.482-1.082,0.004-2.35,1.086-2.833
                                            c0.228-0.101,0.472-0.162,0.72-0.18l9.202-0.658L7.834,2.699c-0.138-0.255-0.211-0.54-0.213-0.83
                                            C7.616,0.944,8.323,0.182,9.229,0.104L9.373,0.097L26.094,0L9.373,0.097z M11.932,10.258l-8.878,0.88
                                            c-0.103,0.01-0.203,0.038-0.297,0.081c-0.425,0.198-0.628,0.679-0.488,1.114l0.042,0.107l15.942,34.281
                                            c0.129,0.278,0.424,0.434,0.72,0.393l0.099-0.021l9.738-2.838c0.037-0.012,0.073-0.025,0.107-0.042
                                            c0.312-0.15,0.459-0.505,0.358-0.825l-0.038-0.096l-5.785-11.969c-0.057-0.119-0.098-0.246-0.119-0.376
                                            c-0.116-0.708,0.328-1.378,1.008-1.557l0.129-0.028l7.624-1.253c0.39-0.064,0.764-0.198,1.106-0.395
                                            c1.521-0.874,2.082-2.777,1.307-4.326l-0.092-0.171l-1.977-3.441l-12.605,2.463c-0.705,0.138-1.418-0.167-1.808-0.758
                                            l-0.079-0.131L11.932,10.258z M24.732,8.99L24.732,8.99l-10.763,1.066l5.573,10.073c0.142,0.256,0.43,0.396,0.72,0.346
                                            l11.454-1.957l-4.838-8.424c-0.378-0.657-1.059-1.07-1.8-1.112L24.906,8.98L24.732,8.99z M25.704,0.892L10.71,1.404
                                            c-0.508,0.017-0.905,0.443-0.888,0.95c0.005,0.145,0.044,0.287,0.114,0.414l3.305,5.974L24.746,7.92
                                            c1.173-0.084,2.29,0.51,2.876,1.529l5.112,8.896l2.682-0.458c1.751-0.299,2.929-1.961,2.629-3.713
                                            c-0.09-0.525-0.309-1.021-0.637-1.441L29.545,2.682C28.624,1.506,27.197,0.84,25.704,0.892z" />
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>

            <div class="links">
                <a href="https://pyrocms.com/docs" target="_blank">Docs</a>
                {{--<a href="https://laracasts.com" target="_blank">Laracasts</a>--}}
                <a href="https://pyrocms.com/posts" target="_blank">News</a>
                {{--<a href="https://blog.laravel.com" target="_blank">Blog</a>--}}
                <a href="https://github.com/pyrocms/pyrocms" target="_blank">GitHub</a>
                @if (env('INSTALLED') == true)
                <a href="{{ url('admin/login') }}">Login</a>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
