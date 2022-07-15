@extends('layouts.web.app')
@section('content')
<style>

    @media (max-width:425px) {
        .diffScreen {
            width: 50%;
        }
    }

    img:hover {
    -webkit-filter: brightness(110%);
}

    </style>
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
        font-size: 16px;
        display: block;
        margin-top: 7px;

    }

    .ActiveGreenColor {

        color: #048ba8;
        font-size: 16px;
        display: block;
        margin-top: 7px;

    }
li {
    list-style: none;
}
ul {
    padding: 0;
}
.caption {
    margin-top: -344px;
    margin-left: 107px;
    color: white;
    text-transform: uppercase;
    text-decoration: auto;
    font-size: 24px;
    font-weight: 600;
    z-index: 1;
    display: none;

}

a:hover h2 {
    display: block !important;
}
    </style>

        <div class="row" style="padding-left: 2%;padding-right: 2%;">
             <div class="col-md-12">
    <nav aria-label="breadcrumb" >
  <ol class="breadcrumb" style="border-bottom: 1px solid lightgrey;font-size: 16px;padding: 14px 0px 15px 0px;">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}" style="color: black;">Home</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ $categoryName }}</li>
  </ol>
</nav>
             </div>
        </div>

        <div class="row" style="min-height: calc(100vh - 40px)">
            <div class="col-md-2" style="border-right: 1px solid lightgrey;padding-left: 2%;">
                <ul>
                   {{--  <?php $url = Request::path() ?>
                        <li>
                            @if(\Request::is('collections/*'))
                            <a class="nav-link" href="{{ url('/' . $url ) }}" class="ActiveGreenColor" style="font-size: 18px;padding: 0px 0px 0px 9px;color: #048ba8;">
                                All
                            </a>
                            @endif
                        </li>  --}}

                        @foreach ($subcategories as $subcategory )
                        @if ($subcategory->status == 'active')

                        <li>
                            <a href="{{ url('/products/singleImage/' . $subcategory->id ) }}"
                                class="nav-link {{ (\Request::is('/products/singleImage/' . $subcategory->id )) ? 'active' : '' }}"
                                style="font-size: 18px;padding: 0px 0px 0px 9px;"
                                >
                                  <span>{{$subcategory->name}}</span>
                            </a>
                        </li>

                        @endif
                        @endforeach
                </ul>
        </div>
        <div class="col-md-10" style="padding: 0px 0px 0px 2%;">
            <div class="row mt-3 mb-3">
                <div class="col-6" style="font-size: 1.5rem;text-transform: capitalize;font-weight: bold;font-size: 19px;">
                {{ $categoryName }}
                </div>
                <div class="col" style="text-align: right;/* display: flex; */">

                <label style="font-size: 14px;">Sort by</label>
                <select style="font-size: 16px;">
                <option>Featured</option>
                <option>Best Selling</option>
                <option>Alphabetically, A-Z</option>
                <option>Alphabetically, Z-A</option>
                <option>Price, low to high</option>
                <option>Price, high to low</option>
                <option>Date, new to old</option>
                <option>Date, old to new</option>
                </select>


                <i class="fa fa-angle-down" aria-hidden="true"></i>

                <a href="#" style=""><i class="fa fa-th-large" aria-hidden="true" style="color: black;"></i></a>
                <a href="#" style="/* margin-left: 117px; */"><i class="fa fa-list" aria-hidden="true" style="color: black;"></i></a>
                </div>

            </div>

        <div class="row tm-mb-90 tm-gallery" style="">

            @foreach ($subcategories as $subcategory )

             <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5 diffScreen">
               <a href="{{ url('/products/singleImage/' . $subcategory->id ) }}">

                    <img src="{{ asset( '/storage/subcategories/96dpiImagesForSub/'.$subcategory->dpiImage) }}" alt="Image" class="img-fluid" style="width: 100%">
                    <figcaption class="d-flex align-items-left justify-content-left">
                        <h2 class="caption">{{ $subcategory->image_title }}</h2>
                    </figcaption>
                </a>
                <p style="font-size: 16.8px;color: black">
                    {{ $subcategory->name }}
                </p>
                <p style="font-size: 16.8px;color: black">
                    {{ $subcategory->image_price }}
                </p>

              </div>

              @endforeach
            </div>
        </div>
        </div>
        <script>
            document.addEventListener('contextmenu', event=> event.preventDefault());
            document.onkeydown = function(e) {
            if(event.keyCode == 123) {
            return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
            return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
            return false;
            }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
            return false;
            }
            }
            </script>
@endsection
