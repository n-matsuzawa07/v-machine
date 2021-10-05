<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/app.css">
  <script src="/js/app.js" defer></script>
  <title>@yield('title')</title>
</head>
<header>
  @include('header')
</header>

<body>

  <div class="container col-lg-10 col-sm-10 text-center">
    <div class="row">
      @yield('content')
    </div>
  </div>
  <footer class="footer bg-dark fixed-bottom">
    @include('footer')
  </footer>
</body>

</html>