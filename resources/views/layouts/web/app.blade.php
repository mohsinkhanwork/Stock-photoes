<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NZ.Photos New Zealand Stockphotos</title>
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/templatemo-style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


</head>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocfoto</title>
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/templatemo-style.css') }}">

</head>
<body class="loaded" style="background: #F7F7F7;">

    <nav class="navbar navbar-expand-lg" style="background: white;">
        <div class="container-fluid" style="margin-left: 0;">
            <a class="navbar-brand" href="{{ route('home') }}" style="padding: 5px;">
                <img src="{{ asset('frontend/img/logo.png') }}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button><div class="d-none d-lg-block" style="width: 50%;margin-top: 10px;padding-left: 60px;">
                <form class="d-flex tm-search-form">
            <input type="search" placeholder="Search photos..." aria-label="Search" style="width: 80%;height: 28px;">
            <button class="btn btn-outline-success tm-search-btn" style="width: 36px;height: 28px;" type="submit">
                <center><i class="fas fa-search"></i></center>

            </button>
        </form>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">

                <li class="nav-item" style="text-align: right;">
                    <a class="" href="{{ route('customer.login_form') }}" style="color: #2f2d2e;font-size:11.9px;font-weight: 700;">Sign in </a> <br>
                    <a class="" href="{{ route('customer.register') }}" style="color: #2f2d2e;font-size:11.9px;font-weight: 700;">New Account</a>
                </li>
                <span style="font-size: 25px;padding: 4px;color: lightgray;">|</span>
                <li class="nav-item">
                    <a class="nav-link nav-link" href="#" style="margin-top: 10%; font-size:0.9rem;"><i style="padding-right: 5px;" class="fas fa-shopping-cart"></i>CART</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>


    <div style="background: white;padding: 25px;">

                <a href="{{ route('home') }}" style="color: black;font-family: &quot;PT Sans&quot;, &quot;HelveticaNeue&quot;, &quot;Helvetica Neue&quot;, sans-serif;font-weight: bold;font-size: 14px;">
                    All
                </a>

                @foreach ($categories as $category )

                @if ($category->status == 'active')


                    <a href="{{ url('collections/' . $category->id . '/' . $category->name  ) }}" style="margin-left: 1%;color: black;font-family: &quot;PT Sans&quot;, &quot;HelveticaNeue&quot;, &quot;Helvetica Neue&quot;, sans-serif;font-weight: bold;font-size: 14px;">
                        {{$category->name}}
                    </a>

                @endif

                @endforeach

    </div>

    {{--  <! -- container -->  --}}
    @yield('content')
    {{--  <!-- container-fluid, tm-container-content -->  --}}

    <footer class="tm-bg-gray pt-5 pb-3 tm-text-gray tm-footer" style="background-color: white;">
        <div>
            <div class="row" style="/* margin-top: -3%; */">
                <div class="col-lg-6 col-md-12 col-12 px-5 mb-5" style="width: 74%;">
                    <h3 class="tm-text-primary mb-4 tm-footer-title">About</h3>
                    <p style="font-size: 14px;width: 60%;">

                    At nz.photos we are passionate about New Zealand and very selective with the photos we offer. Our goal is to work only with the highest quality, high-resolution images. If you need stunning and unique New Zealand photos, you came to the right place.
</p>
</div>

                <div class="col-lg-3 col-md-6 col-6 col-6 px-3 mb-3" style="/* margin-top: 2%; */font-size: 1.133em;">
                     <h3 href="#" class="tm-text-gray text-right d-block mb-2" style="font-size: 14px;
    line-height: 1.6;
    font-family: &quot;PT Sans&quot;, &quot;HelveticaNeue&quot;, &quot;Helvetica Neue&quot;, sans-serif;
    color: #2e4057;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    -webkit-text-size-adjust: 100%;">Featured</h3>
                    <a href="#" class="tm-text-gray text-right d-block" style="font-size: 14px;
    line-height: 1.6;
    font-family: &quot;PT Sans&quot;, &quot;HelveticaNeue&quot;, &quot;Helvetica Neue&quot;, sans-serif;
    color: #2e4057;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    -webkit-text-size-adjust: 100%;">Westhaven Marina Sunset</a>
                    <a href="#" class="tm-text-gray text-right d-block" style="font-size: 14px;
    line-height: 1.6;
    font-family: &quot;PT Sans&quot;, &quot;HelveticaNeue&quot;, &quot;Helvetica Neue&quot;, sans-serif;
    color: #2e4057;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    -webkit-text-size-adjust: 100%;">Southern Alps Cromwel</a>
                    <a href="#" class="tm-text-gray text-right d-block" style="font-size: 14px;
    line-height: 1.6;
    font-family: &quot;PT Sans&quot;, &quot;HelveticaNeue&quot;, &quot;Helvetica Neue&quot;, sans-serif;
    color: #2e4057;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    -webkit-text-size-adjust: 100%;">Mount Eden Views</a>
                </div>
            </div>


            <div class="row" style="border-top: 1px solid;border-top-color: f2f2f2;padding-top: 15px;border-bottom: 1px solid;border-bottom-color: f2f2f2;">
                <div class="col-lg-8 col-md-7 col-12 px-5 mb-3">
                    <a href="{{ url('pages/about')}}" style="font-size: 13px;color: #2f2d2e;"> About </a>
                    <span><span> <a href="{{ url('pages/contact')}}" style="margin-left: 5px;font-size: 13px;color: #2f2d2e;"> Contact </a> </span></span>

                    <span> <a href="{{ url('pages/lisence') }}" style="margin-left: 5px;font-size: 13px;color: #2f2d2e;"> Lisence Terms </a> </span>
                    <span> <a href="{{ url('pages/copyright') }}" style="margin-left: 5px;font-size: 13px;color: #2f2d2e;"> Copyright </a> </span>
                     <span> <a href="{{ url('pages/privacy') }}" style="margin-left: 5px;font-size: 13px;color: #2f2d2e;"> Privacy Policy </a> </span>
                </div>
                <div class="col-lg-4 col-md-5 col-12 px-5 text-right">
                    <i class="fab fa-twitter" style="font-size: 20px; color: black;line-height: 16px;"></i>
                    <span><i style="font-size: 20px; color: black;line-height: 16px;" class="fab fa-facebook-square"></i></span>
                </div>
            </div>

<div class="row" style="padiing-top: 15px;margin-top: 15px;">
                <div class="col-lg-8 col-md-7 col-12 px-5 mb-3">

                        <a style="font-size: 13px;color: #2f2d2e;"> © 2022 DAY Investments Ltd </a>
                        <span><a style="margin-left: 10px;font-size: 13px;color: #2f2d2e;"> Designed by </a><a href="https://ahdustechnology.com/"> ahdustechnology.com </a> </span>


                </div>
                <div class="col-lg-4 col-md-5 col-12 px-5 text-right">
                    <span style="padding-right: 10px;"><i style="font-size: 35px; color: black;" class="fab fa-cc-amex"></i></span>
                    <span style="padding-right: 10px;"><i style="font-size: 35px; color: black;" class="fab fa-apple-pay"></i></span>
                    <span style="padding-right: 10px;"><i style="font-size: 35px; color: black;" class="fab fa-cc-mastercard"></i></span>
                    <span style="padding-right: 10px;"><i style="font-size: 35px; color: black;" class="fab fa-cc-paypal"></i></span>
                    <span style="padding-right: 10px;"><i style="font-size: 35px; color: black;" class="fab fa-shopify"></i></span>
                    <span><i style="font-size: 35px; color: black;" class="fab fa-cc-visa"></i></span>
                </div>
            </div>

        </div>
    </footer>

   <!-- <script src="js/plugins.js"></script>
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script> -->

</body></html>

</html>
