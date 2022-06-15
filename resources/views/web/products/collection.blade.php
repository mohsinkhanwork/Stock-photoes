@extends('layouts.web.app')
@section('content')


<div style="padding-left: 2%;padding-right: 2%;">

            <div class="row mb-4">

        <div class="row">
             <div class="col-md-12">
    <nav aria-label="breadcrumb" >
  <ol class="breadcrumb" style="padding-left: 0;border-bottom: 1px solid lightgrey;">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}" style="color: black;">Home</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ $categoryName }}</li>
  </ol>
</nav>
<div class="row mt-3 mb-3" style="">
    <div class="col-6" style="font-size: 1.5rem;">
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
<div class="row tm-mb-90 tm-gallery">

        @foreach ($subcategories as $subcategory )


        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5 diffScreen">
            <a href="{{ url('/products/singleImage/' . $subcategory->id ) }}">
                <figure>
                    <img src="{{ asset( '/storage/subcategories/'.$subcategory->image) }}" alt="Image" class="img-fluid" style="width: 100%">
                    <figcaption class="d-flex align-items-left justify-content-left">
                        <p style="color: black;"> {{ $subcategory->image_title }} <br>
                            <small style="font-size: 16.8px;">
                                ${{ $subcategory->image_price }}
                            {{-- <sup>00</sup> --}}
                        </small>
                        </p>
                    </figcaption>
                </figure>
                </a>
        </div>

        @endforeach

</div>

  </div>
    </div>

</div>
          </div>


@endsection
