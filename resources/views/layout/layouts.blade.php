<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{env('APP_NAME')}}</title>
  <link rel="icon" href="{{asset('assets/img/icon-ysp.png')}}" sizes="32x32 48x48">

@include('layout.partials.links')
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
     @include('layout.partials.navbar')

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2025 <div class="bullet"></div> Design By <a href="https://nauval.in/">Citra Febriawirti</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>

  @include('layout.partials.script')
</body>
</html>