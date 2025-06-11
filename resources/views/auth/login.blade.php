<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

      <link rel="icon" href="{{asset('assets/img/icon-ysp.png')}}" sizes="32x32 48x48">

    <link rel="stylesheet" href="{{asset('assets_login/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('assets_login/css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets_login/css/bootstrap.min.css')}}">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{asset('assets_login/css/style.css')}}">

    <title>{{env('APP_NAME')}}</title>

  </head>
  <body>
  

  <div class="d-lg-flex half">
  <div class="bg order-1 order-md-2" style="background-image: linear-gradient(to right, rgba(0, 128, 255, 0.4), rgba(255, 0, 128, 0.4)), url('{{ asset('assets_login/images/sph.png') }}');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-9">
            <h3>Login to <strong>YSP-MAGANG</strong></h3>
            <p class="mb-4">Silahkan inputkan data dengan benar !</p>
            <form  method="post" action="{{ route('login') }}">
                 @csrf
              <div class="form-group first">
                <label for="username">Username</label>
                <input id="username" type="username" class="form-control" name="username" tabindex="1" required autofocus value="{{ old('username') }}">
                  @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
               <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                 <i class="fa-solid fa fa-eye" id="eye" style="position: absolute; top: 245px; right: 35px; cursor: pointer; color: #888"></i>
                      @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
              </div>
              
        

                <button type="submit" class="btn btn-submit btn-lg btn-block" tabindex="4">
                      Login
                    </button>

            </form>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
       <script>
      const passwordInput = document.querySelector("#password");
      const eye = document.querySelector("#eye");

      eye.addEventListener("click", function () {
        const isPassword = passwordInput.getAttribute("type") === "password";
        passwordInput.setAttribute("type", isPassword ? "text" : "password");

        // Toggle class satu per satu
        this.classList.toggle("fa-eye-slash");
      });
    </script>

    <script src="  {{asset('assets_login/js/jquery-3.3.1.min.js')}}"></script>
    <script src=" {{asset('assets_login/js/popper.min.js')}}"></script>
    <script src=" {{asset('assets_login/js/bootstrap.min.js')}}"></script>
    <script src=" {{asset('assets_login/js/main.js')}}"></script>
  </body>
</html>