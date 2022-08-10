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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>

<style>

    @media (max-width: 1326px) {
        .logoStoc {
            padding: 5px 5px 5px 23px;
            width: 30%;

        }
        .mainMenuCat {
            background: white;
            padding: 0px 0px 0px 20px;
            display: flex;
        }
    }

    .logoStoc {
        padding: 5px 5px 5px 17px;
        width: 30%;
    }
    .mainMenuCat {
        background: white;
        padding: 0px 0px 0px 18px;
        display: flex;
    }

</style>

<body style="background: #F7F7F7;overflow-x: hidden;">

    <nav class="navbar navbar-expand-lg" style="background: white;margin: 0;">
        <div style="margin-left: 0;width: 100%;display: flex;">
            <a class="navbar-brand logoStoc" href="{{ route('home') }}">
                <img src="{{ asset('frontend/img/logo.png') }}">
            </a>

            <div class="d-none d-lg-block" style="width: 46%;margin-top: 10px;">
                <form class="d-flex tm-search-form" style="width: 100%;font-size: 16px;">
            <input type="search" placeholder="Search photos..." aria-label="Search" style="width: 80%;height: 40px;border: 1px solid black;font-size: 14px;padding: 1%;">
            <button class="btn btn-outline-success tm-search-btn" style="width: 45px;height: 40px;" type="submit">
                <center><i class="fas fa-search"></i></center>

            </button>
        </form>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="width: 21%;justify-content: right;display: flex !important;">
                <ul class="navbar-nav">
                <li class="nav-item" style="text-align: right;padding-top: 11px;">
                    <a href="{{ route('customer.login_form') }}" style="color: #2f2d2e;font-size:11.9px;font-weight: 700;padding: 0;">
                        Sign in </a>
                        <br />
                        <a href="{{ route('customer.register') }}" style="color: #2f2d2e;font-size:11.9px;font-weight: 700;padding: 0;">
                        New Account
                    </a>
                </li>

                <span style="font-size: 25px;padding: 4px;color: lightgray;">|</span>
                <li class="nav-item">
                    <a class="nav-link nav-link" href="#" style="margin-top: 10%;font-size: 14px;">
                        <i style="padding-right: 5px;" class="fas fa-shopping-cart"></i>CART
                    </a>
                </li>
            </ul>


            </div>
        </div>
    </nav>
<style>
    a.active{
color: #048ba8;
}

a:hover {
text-decoration: none;
}

a:focus {
    text-decoration: none;


}
.AllCategories {
    color: black;
    display: block;
    margin-top: 0.25%;
    font-size: 15px;

}

.ActiveGreenColor {

    color: #048ba8;
    display: block;
    margin-top: 0.25%;
    font-size: 15px;

}

input[type=search] {

    outline-offset: 0px;

}

</style>

    <div class="mainMenuCat">

        {{--  @if (\Request::is('/'))
                <a href="{{ route('home') }}" class="ActiveGreenColor" style="font-size: 14px;color: black;">
                    All
                </a>
        @else
        <a href="{{ route('home') }}" class="AllCategories">
            All
        </a>
        @endif  --}}

                <ul class="list-inline" style="width: 100%;">
                @foreach ($categories as $category )
                @if ($category->status == 'active')
                    <li class="nav-item">
                        <a href="{{ url('collections/' . $category->id . '/' . $category->name  ) }}"
                            class="nav-link {{ (\Request::is('collections/' . $category->id . '/' . $category->name  )) ? 'active' : '' }}"
                            style="font-size: 14px;color: black;"
                            >
                        {{$category->name}}
                        </a>
                    </li>
                @endif
                @endforeach
            </ul>

    </div>

    {{--  <! -- container -->  --}}
    @yield('content')
    {{--  <!-- container-fluid, tm-container-content -->  --}}


    <footer class="footer px-5 text-light" style="
display: flex;
font-size: 14px;
background-color: #444;
padding: 2%;">
        <div class="col-md">
            Copyright © 2002-2022 DAY Investments Ltd. – All rights reserved
        </div>
        <div class="col-auto" style="font-size: 16px">

               <a href="{{ url('pages/about')}}" style="font-size: 13px;color: white"> About </a>
               <span><span> <a href="{{ url('pages/contact')}}" style="margin-left: 5px;font-size: 13px;color: white;"> Contact </a> </span></span>
               <span> <a href="{{ url('pages/lisence') }}" style="margin-left: 5px;font-size: 13px;color: white"> Lisence Terms </a> </span>
               <span> <a href="{{ url('pages/copyright') }}" style="margin-left: 5px;font-size: 13px;color: white"> Copyright </a> </span>
                <span> <a href="{{ url('pages/privacy') }}" style="margin-left: 5px;font-size: 13px;color: white"> Privacy Policy </a> </span>
        </div>
    </footer>
</body>
</html>

