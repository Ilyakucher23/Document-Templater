<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, user-scalable=false;">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    </script>
    <script src="https://kit.fontawesome.com/599f7737e5.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/599f7737e5.js" crossorigin="anonymous"></script>

    <script src="{{ asset('assets/vendor/ckeditor5/build/ckeditor.js') }}"></script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script type="text/javascript" src="http://twitter.github.io/bootstrap/assets/js/bootstrap-transition.js"></script>
    <script type="text/javascript" src="http://twitter.github.io/bootstrap/assets/js/bootstrap-collapse.js"></script>

    <title>@yield('title')</title>
    <style>
        @media (min-width: 10px) and (max-width: 768px) {
            html {
                font-size: 16px;
                padding-left: 0px !important;
                margin: 0px !important;
            }

            #hero {
                font-size: 16px;
                padding-left: 10px !important;
                padding-right: 10px !important;
                margin: 0px !important;
                margin-left: 0px !important;
                margin-right: 0px !important;
            }


        }

        /* @media (min-width: 991.98px) {
            .hero {
                padding-left: 10rem;
                padding-right: 10rem;
            }


        } */
    </style>
    <script>
        /*to prevent Firefox FOUC, this must be here*/
        let FF_FOUC_FIX;
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light border">
        <div class="container-fluid">
            <div class="nav-item">
                <a href="/" class="nav-link link-body-emphasis px-2 active"
                    aria-current="page">@lang('public.home')</a>
            </div>
            <div class="dropdown me-auto">
                <button style="min-width: 100px !important;" class="btn btn-light dropdown-toggle"
                    id="dropdownMenuButton" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                    @lang('public.lang_selector')
                </button>
                <ul style="min-width: 100px !important;" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a href="locale/en" class="dropdown-item"><img src="https://flagcdn.com/w20/gb.png"
                                srcset="https://flagcdn.com/w40/gb.png 2x" alt="United Kingdom"> EN </a>
                    </li>
                    <li><a href="locale/ukr" class="dropdown-item"><img src="https://flagcdn.com/w20/ua.png"
                                srcset="https://flagcdn.com/w40/ua.png 2x" alt="Ukraine"> UA </a>
                    </li>
                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item"><a href="/create"
                                class="nav-link link-body-emphasis px-2">@lang('public.create_new_template_file')</a>
                        </li>
                    @endauth
                    <li class="nav-item"><a href="/default-templates" class="nav-link link-body-emphasis px-2 active"
                            aria-current="page">@lang('public.static-templ')</a>
                    </li>
                </ul>

                <form class="inline" methon='GET' action="{{ route('logout') }}">
                    <ul class="nav">
                        @auth
                            <li class="nav-item"><span class="nav-link link-body-emphasis px-2">@lang('public.welcome')
                                    {{ auth()->user()->name }}</span></li>
                            <li class="nav-item"><button type="submit"
                                    class="nav-link link-body-emphasis px-2">@lang('public.logout') <i
                                        class="fa-solid fa-arrow-right-from-bracket"></i></button>
                            </li>
                        @else
                            <li class="nav-item"><a href="/login"
                                    class="nav-link link-body-emphasis px-2">@lang('public.login')</a></li>
                            <li class="nav-item"><a href="/registration"
                                    class="nav-link link-body-emphasis px-2">@lang('public.sign_up')</a>
                            </li>
                        @endauth
                    </ul>
                </form>
            </div>
        </div>
    </nav>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="alert alert-primary position-fixed top-10 start-50 translate-middle text-white border-0"
            style="z-index: 999;">
            {{ session('message') }}
        </div>
    @endif
    <main class="m-0 w-100">@yield('content')</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
