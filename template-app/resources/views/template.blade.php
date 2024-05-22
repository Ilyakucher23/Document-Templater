<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    </script>
    <script src="https://kit.fontawesome.com/599f7737e5.js" crossorigin="anonymous"></script>
    {{-- TRIX 
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script> --}}
    <script src="https://kit.fontawesome.com/599f7737e5.js" crossorigin="anonymous"></script>

    {{-- ckeditor 5 --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/decoupled-document/ckeditor.js"></script> --}}
    <script src="{{ asset('assets/vendor/ckeditor5/build/ckeditor.js') }}"></script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    {{--  <script src="{{ asset('assets/vendor/ckeditor5/build/plugin.js') }}"></script> --}}
    <title>@yield('title')</title>
</head>

<body>
    <nav class="py-2 bg-body-tertiary border-bottom">
        <div class="container d-flex flex-wrap">
            <ul class="nav me-auto">
                <li class="nav-item"><a href="/" class="nav-link link-body-emphasis px-2 active"
                        aria-current="page">@lang('public.home')</a></li>
                @auth
                    <li class="nav-item"><a href="/create" class="nav-link link-body-emphasis px-2">@lang('public.create_new_template_file')</a>
                    </li>
                @endauth
            </ul>

            <div class="dropdown">
                <button style="min-width: 100px !important;" class="btn btn-light dropdown-toggle" id="dropdownMenuButton"  data-bs-toggle="dropdown" type="button" aria-expanded="false">
                    @lang('public.lang_selector')
                </button>
                <ul style="min-width: 100px !important;" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a href="locale/en" class="dropdown-item"><img src="https://flagcdn.com/w20/gb.png"
                                srcset="https://flagcdn.com/w40/gb.png 2x" 
                                alt="United Kingdom"> EN </a>
                    </li>
                    <li><a href="locale/ukr" class="dropdown-item"><img src="https://flagcdn.com/w20/ua.png"
                                srcset="https://flagcdn.com/w40/ua.png 2x" alt="Ukraine"> UA </a>
                    </li>
                </ul>
            </div>
            {{-- <select class="selectpicker" data-width="fit">
                <option data-content='<span class="flag-icon flag-icon-us"></span> English'>English</option>
                <option data-content='<span class="flag-icon flag-icon-mx"></span> Español'>Español</option>
            </select> --}}

            <form class="inline" methon='GET' action="{{ route('logout') }}">
                <ul class="nav">
                    @auth
                        <li class="nav-item"><span class="nav-link link-body-emphasis px-2">@lang('public.welcome')
                                {{ auth()->user()->name }}</span></li>
                        <li class="nav-item"><button type="submit"
                                class="nav-link link-body-emphasis px-2">@lang('public.logout')</button>
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
    </nav>

    <main class="m-0 w-100">@yield('content')</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</body>

</html>
