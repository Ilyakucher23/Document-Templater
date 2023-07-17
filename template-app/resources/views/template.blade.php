<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/599f7737e5.js" crossorigin="anonymous"></script>
    <title>@yield('title')</title>
</head>

<body>
    <nav class="py-2 bg-body-tertiary border-bottom">
        <div class="container d-flex flex-wrap">
          <ul class="nav me-auto">
            <li class="nav-item"><a href="#" class="nav-link link-body-emphasis px-2 active" aria-current="page">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link link-body-emphasis px-2">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link link-body-emphasis px-2">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link link-body-emphasis px-2">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link link-body-emphasis px-2">About</a></li>
          </ul>
          <ul class="nav">
            <li class="nav-item"><a href="#" class="nav-link link-body-emphasis px-2">Login</a></li>
            <li class="nav-item"><a href="#" class="nav-link link-body-emphasis px-2">Sign up</a></li>
          </ul>
        </div>
      </nav>

    <main class="container my-3 px-3">@yield('content')</main>
</body>

</html>
