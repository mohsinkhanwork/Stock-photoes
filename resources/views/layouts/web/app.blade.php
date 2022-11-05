<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NZ.Photos New Zealand Stockphotos</title>
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fontawesome/css/all.min.css') }}">
      {{--  <link rel="stylesheet" href="{{ asset('frontend/css/templatemo-style.css') }}">  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    {{--    --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('flex2/jquery-mosaic/jquery.mosaic8e0e.css?v=8') }}"/>
	<script type="text/javascript" src="{{ asset('flex2/jquery-mosaic/jquery.mosaic8e0e.js?v=8') }}"></script>
	<script type="text/javascript" src="{{ asset('flex2/res/js/mainbea6.js?v=7') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('flex2/jquery.mosaic.css') }}" />
    <script type="text/javascript" src="{{ asset('flex2/jquery.mosaic.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{--    --}}

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
        padding: 5px 5px 5px 3px;
        width: 30%;
    }
     .mainMenuCat {
        background: white;
        display: flex;
        padding-left: 1%;
    }


</style>

<style>

    form.example input[type=text] {
        padding: 5px 10px 5px 10px;
        border: 1px solid grey;
        float: left;
        width: 95%;
        border-right: none;
        box-sizing: border-box;
    }

    form.example button {
          /* width: 3%; */
          padding: 6px 0px 7px 0px;
        font-size: 17px;
        border: 1px solid grey;
        border-left: none;
        cursor: pointer;
         box-sizing: border-box;
    }

    form.example::after {
      content: "";
      clear: both;
      display: table;
    }
    </style>

<body style="background: #F7F7F7;overflow-x: hidden;">

    <nav class="navbar navbar-expand-lg" style="background: white;margin: 0;padding: 10px;">
        <div style="margin-left: 0;width: 100%;display: flex;">
            <div class="logoStoc">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('frontend/img/newlogo.png') }}" width="45%;">
                </a>
            </div>
            <div class="d-none d-lg-block" style="width: 40%;margin-top: 16px;">
            <form class="example" action="/action_page.php">
                <input type="text" placeholder="Search" name="search">
                <button type="submit" style="background: white;"><i class="fa fa-search"></i></button>
              </form>
        </div>
        </form>


            <div class="navbar-expand collapse navbar-collapse" id="navbarSupportedContent"
            style="width: 30%;text-align: right;padding: 18px 11px 10px 0px;">
                {{--  <ul class="navbar-nav">
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
                </li>  --}}

                <a href="#" class="btn btn-primary" style="border: none">
                    <i class="fa-solid fa-clone"></i> BOARDS
                </a>
                <a href="#" class="btn btn-primary" style="border: none">
                    <i class="fa-solid fa-cart-shopping"></i> BASKET
                </a>
                <a href="{{ route('customer.login_form') }}" class="btn btn-primary" style="border: 1px solid black">
                    SIGN IN
                </a>
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

<style>
    ul{
        padding: 0;
        list-style: none;
        background: #f2f2f2;
    }
    ul li a{
        display: block;
        padding: 2px 6px 0px 9px;
        color: #333;
        text-decoration: none;
        border-bottom: 3px solid transparent;
    }
    ul li{
        position: relative;
    }
    .list-inline li a:hover{
        /* display: block; */
        /* padding: 2px 6px 0px 9px; */
        /* color: #222222 !important; */
        /* background-color: #FFFFFF; */
        /* padding-top: 10px !important; */
        /* padding-bottom: 6px !important; */
        /* height: 24px !important; */
        border-bottom: 3px solid #8DB160;
        /* outline: 3px solid #57DBD7; */
        /* outline-offset: -1px; */
        /* opacity: 1.0; */
        /* text-shadow: none; */
        /* margin-top: 0px; */
        transition: background-color 0.250s;
    }
    .dropdown li a:hover {
        border-bottom: 1px solid grey;
    }
    .dropdown li a {
        display: initial;
    padding: 0px;
    text-decoration: none;
    font-size: 10pt;
    font-family: arial;
    font-weight: normal;
    color: black;
    line-height: 18px;
    border-bottom: 3px solid transparent;
    text-transform: capitalize;
    }

    .dropdown li {

    }
    ul li ul.dropdown{
        min-width: 225px;
        background: #f2f2f2;
        display: none;
        position: absolute;
        z-index: 999;
        /* top: 34px;  */
        margin-top: 0px;
        border: 1px solid #AAAAAA;
        border-top: 1px solid #AAAAAA;
        /* box-shadow: 0px 5px 25px -15px #eeeeee; */
        /* position: absolute; */
        /* box-sizing: border-box; */
        /* width: 100%; */
        /* left: 0px; */
        /* top: 0px; */
        /* z-index: 2000; */
        padding: 20px 6px 30px 15px;
        /* margin-top: -1px; */
        /* visibility: hidden; */
        border: 1px solid #A6A6A6;
        /* background-color: #FFFFFF; */
    }
    ul li:hover ul.dropdown{
        display: block;	/* Display the dropdown */
        background: white;
    }

    .list-inline {
        padding-left: 0;
        list-style: none;
        margin-left: 0px !important;
        background: white;
    }
    .list-inline>li {
        /* display: inline-block; */
        /* padding-right: 5px; */
        float: left;
        /* padding: 0px; */
        /* margin: 0px; */
        /* list-style: none; */
        font: 10pt arial;
        padding-left: 5px;
    }
    .nav-link {
        /*padding: 0px;  */
    }
    ul li:hover a.borderBottom {
        border-bottom: 3px solid #8DB160;
    }

    .btn-primary {
        color: black;
        font-family: inherit;
        background-color: white;
        font-weight: 600;
        font-size: 14px;
    }
    .btn-primary:hover {
        color: black;
        background-color: white;
    }
    .btn-primary:active:focus {
        color: black;
        background-color: white;
        border: none;
    }
    .btn-primary:active {
        color: black;
        background-color: white;
        border: none;
    }
    .btn-primary.focus, .btn-primary:focus {
        color: black;
        background-color: white;
        border: none;
        box-shadow: none;
    }

    input:focus-visible {
        outline: 1px solid white;
    outline-offset: -2px;
    }
    :focus-visible {
        outline: 1px solid white;
        outline-offset: -2px;
    }
    button:focus {
        /* outline: 1px dotted; */
        outline: 0px auto -webkit-focus-ring-color;
    }
</style>

    <div class="row" style="margin: auto;padding: 14px;background: white;">

                <ul class="list-inline">
                    <li>
                        <a href="#" class="nav-link">
                            Newest
                        </a>
                    </li>
                @foreach ($categories as $category )
                @if ($category->status == 'active')
                {{--  //get subcategories of category  --}}
                @php
                $subcategories = App\Subcategory::where('category_id', $category->id)->get();
                @endphp
                {{--  //check if category has subcategories  --}}
                @if (count($subcategories) > 0)
                <li>
                    <a href="{{ url('collections/' . $category->id . '/' . $category->name  ) }}" class="nav-link {{ (request()->is('collections/' . $category->id . '/' . $category->name  )) ? 'active' : '' }} borderBottom">
                        {{ $category->name }}
                    </a>
                    <ul class="dropdown">
                        @foreach ($subcategories as $subcategory)
                        @if ($subcategory->status == 'active')
                        <li>
                        <a href="{{ route('photo.collections',['categoryId' =>$category->id,'categoryName' => $category->name,'subcategoryId' => $subcategory->id,'subcategoryName' => $subcategory->name]) }}">
                            {{ $subcategory->name }}
                        </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </li>
                @else

                <li>
                    <a href="{{ url('collections/' . $category->id . '/' . $category->name  ) }}" class="nav-link {{ (request()->is('collections/' . $category->id . '/' . $category->name  )) ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                </li>
                @endif
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
        <div class="col-md" style="color: white;">
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

