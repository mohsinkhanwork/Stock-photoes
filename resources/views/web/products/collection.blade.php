@extends('layouts.web.app')
@section('content')
    <style>
        a.active{
    color: #048ba8;
    }

    .AllCategories {
        color: black;
        font-size: 16px;
        display: block;
        margin-top: 7px;

    }

    .ActiveGreenColor {
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

.img__wrap {
    position: relative;
  }

  .img__description {
    position: absolute;
    bottom: 0px;
    left: 0px;
    right: 0px;
    color: #fff;
    visibility: hidden;
    opacity: 0;
    background: linear-gradient(rgba(183, 135, 152, -107.849), rgb(76, 76, 76) 127%);

    /* transition effect. not necessary */
    transition: opacity .2s, visibility .2s;
  }
  .img__wrap:hover .img__description {
    visibility: visible;
    opacity: 1;
    height:auto;
  }

.col-lg-4 {
    padding-right: 9px;
}

 .imgCollection {
    width: 100%;
    box-shadow: 3px 2px 7px grey;
    border-radius: 6px;
}


.zoom {
    transition: transform .2s; /* Animation */
  }

  .zoom:hover {
    transform: scale(1.02);
  }

  .pagination {
    display: inline-block;
    padding-left: 0;
    margin: 0px 0px 10px 10px;
    border-radius: 4px;
}
.page-item.active .page-link {
    z-index: 3 !important;
    color: black !important;
    background-color: #0d6efd !important;
    border: 0px solid grey !important;
}

      </style>


      <script>
        $(document).ready(function() {
	    $('#mosaic').Mosaic({
			innerGap:10,
            maxRowHeight: 300,
            maxRowHeightPolicy: 'tail'
		});

   });
</script>
        {{--  <div class="row" style="padding-left: 1.1%;padding-right: 2%;width: 100%;">
             <div class="col-md-12" style="padding-left: 7px;">
    <nav aria-label="breadcrumb" >
  <ol class="breadcrumb" style="border-bottom: 1px solid lightgrey;font-size: 15px;padding: 14px 0px 15px 0px;">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}" style="color: black;">Home</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ $categoryName }}</li>
  </ol>
</nav>
             </div>
        </div>  --}}

        <div class="row" style="min-height: calc(100vh - 40px);margin: auto;border-top: 1px solid gainsboro;">
            <div class="col-md-2" style="border-right: 1px solid lightgrey;padding-left: 1.1%;padding-top: 1%;background: white">
                <ul style="background: none">

                        <li>
                            <a class="nav-link {{ (request()->is('collections/'.$categoryId.'/'.$categoryName)) ? 'active' : '' }}"
                            href="{{ route('collections',['categoryId' =>$categoryId,'categoryName' => $categoryName]) }}" class="ActiveGreenColor"
                            style="font-size: 15px;padding: 0px 0px 0px 9px;">
                                All
                            </a>
                        </li>

                        @foreach ($subcategories as $subcategory )
                        @if ($subcategory->status == 'active')

                        <li>
                            {{--  url for subcategory photo  --}}
                            <a class="nav-link {{ (request()->is('collections-photo/cat-id/'.$categoryId.'/cat/'.$categoryName.'/sub-id/'.$subcategory->id.'/sub/'.$subcategory->name)) ? 'active' : '' }}"
                                href="{{ route('photo.collections',['categoryId' =>$categoryId,'categoryName' => $categoryName,'subcategoryId' => $subcategory->id,'subcategoryName' => $subcategory->name]) }}"
                            style="font-size: 15px;padding: 0px 0px 0px 9px;">
                                {{ $subcategory->name }}
                            </a>
                        </li>
                        @endif
                        @endforeach
                </ul>
        </div>
        <style>
            .filterData {
margin-right: 7px;
          }

        </style>
        <div class="col-md-10" style="margin-bottom: 1%;padding: 0px;background: white;">
            <div class="row" style="background: white;margin: auto;padding: 1%;">
                <div class="filterData" style="text-align: right">
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

{{--
                    <i class="fa fa-angle-down" aria-hidden="true"></i>

                    <a href="#" style=""><i class="fa fa-th-large" aria-hidden="true" style="color: black;"></i></a>
                    <a href="#" style="/* margin-left: 117px; */"><i class="fa fa-list" aria-hidden="true" style="color: black;"></i></a>  --}}

                </div>
            </div>


            <div class="row" style="margin: auto;background: #F7F7F7;border-top: 1px solid gainsboro;">
            <div class="row mt-3 mb-3" style="background: #F7F7F7;margin: auto;">
                <div class="row" style="margin: auto">


                <div class="col-md-6" style="font-size: 18px;padding: 0px">
                {{--  {{ $categoryName }}  --}}
                @if ($latestPhotos->hasPages())
                <ul style="background: none;">
                    {{-- Previous Page Link --}}
                    {{--  @if ($latestPhotos->onFirstPage())
                        <li class="disabled"><span>{{ __('Prev') }}</span></li>
                    @else
                        <li><a href="{{ $latestPhotos->previousPageUrl() }}" rel="prev">{{ __('Prev') }}</a></li>
                    @endif  --}}



                    {{ $latestPhotos->firstItem() . "-" . $latestPhotos->lastItem() ."  of  " . $latestPhotos->total() . " Photos "}}


                    {{-- Next Page Link --}}
                    {{--  @if ($latestPhotos->hasMorePages())
                        <li><a href="{{ $latestPhotos->nextPageUrl() }}" rel="next">{{ __('Next') }}</a></li>
                    @else
                        <li class="disabled"><span>{{ __('Next') }}</span></li>
                    @endif  --}}
                </ul>
            @endif


                </div>
                <div class="col-md-6" style="text-align: right;padding: 0;">
                {{ $latestPhotos->links() }}
             {{--  <ul class="pagination">
                    @if ($latestPhotos->onFirstPage())
                        <li class="disabled"></li>
                    @else
                        {{--  <li><a href="{{ $latestPhotos->previousPageUrl() }}" rel="prev">{{ __('Prev') }}</a></li>  --}}
                    {{--  @endif  --}}

                    {{--  <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $latestPhotos->currentPage() }}</span>
                    </li>  --}}

                    {{--  <li class="page-item">
                        <a class="page-link" href="http://127.0.0.1:8000/collections/1/animal%20category?page=2">
                            2
                        </a>
                    </li>  --}}

                   {{-- Next Page Link --}}
                     {{--  @if ($latestPhotos->hasMorePages())  --}}
                        {{--  <li><a href="{{ $latestPhotos->nextPageUrl() }}" rel="next">Next</a></li>  --}}
                    {{--  @else  --}}
                        {{--  <li class="disabled"><span>Next</span></li>  --}}
                    {{--  @endif  --}}
                {{--  </ul>  --}}

                </div>
            </div>

            <style>
                .jQueryMosaic > .item:hover > .saveText {
                    opacity: 1;
                }
                .jQueryMosaic > .item > .saveText {
                    opacity: 0;
                    position: absolute;
                    text-align: right;
                    /*  left: 0px; */
                    right: 6px;
                    top: 10px;
                    /* bottom: 30px; */
                    transition: opacity .2s ease-in-out;
                    -moz-transition: opacity .2s ease-in-out;
                    -webkit-transition: opacity .2s ease-in-out;
                }

                .jQueryMosaic > .item > .saveText > .texts {
                   /* position: absolute; */
                    left: 0px;
                    right: 0px;
                    bottom: 0px;
                    padding: 10px 10px 10px 13px;
                    background: rgba(87,87,89,0.35);
                    color: #fff;
                    font-size: 16px;
                }
            </style>


            <div id="mosaic" class="mosaic" style="background: #F7F7F7;">

        @foreach ($latestPhotos as $key => $latestPhoto)
            @if ($latestPhoto->status == 'on')

            @php
            $height = Image::make(storage_path('/app/public/photos/').$latestPhoto->image)->height();
            $width = Image::make(storage_path('/app/public/photos/').$latestPhoto->image)->width();
            @endphp


            <a class="item withImage" href="{{ url('/collection/image/'.$latestPhoto->category_id.'/'.$latestPhoto->sub_category_id.'/'.$latestPhoto->id) }}" width={{ $width }} height={{ $height }}
                style="background-color: #69DF7B;
                background-image: url({{asset('storage/photos/'.$latestPhoto->image)}});" data-high-res-background-image-url="{{ asset('storage/photos/'.$latestPhoto->image) }}">
                <div class="overlay">
                    <div class="texts">
                    <p style="margin-bottom: 4px;line-height: 15px;">{{ $latestPhoto->description  }}</p>
                    </div>
                </div>

                <div class="saveText">
                    <div class="texts">
                    <p style="margin: 0px">
                        <span>
                            +
                        </span>
                        <span>
                            Save
                        </span>
                    </p>
                    </div>
                </div>
        </a>

            {{--  <div class="img zoom ">
                <a href="{{ url('/products/singleImage/' . $latestPhoto->id ) }}">
                <img src="{{ asset('storage/photos/'.$latestPhoto->image) }}" />
                </a>
                <p style="margin-bottom: 4px;line-height: 17px;">{{ $latestPhoto->description  }}</p>
              </div>  --}}
            @endif
        @endforeach



</div>
</div>







        </div>
        </div>

        {{-- <script>
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
            </script> --}}

@endsection
