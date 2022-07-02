@extends('layouts.web.app')
@section('content')

<style>

img:hover {
    -webkit-filter: brightness(110%);

}

a:hover h2 {
    //display: block !important;
}

@media (max-width:425px) {
    .diffScreen {
        width: 50%;
    }

    .caption {
        margin-top: -34px !important;
         display: block !important;

    }
}

.caption {
    margin-top: -60px;
    margin-left: 10px;
    color: white;
    z-index: 1;
    //display: none;

}


</style>

<div style="padding: 1%;">

    <div class="row">
        @foreach ($categories as $category )

        @if ($category->status == 'active')
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 diffScreen" style="margin-bottom: 1%;">
            <a href="{{ url('collections/' . $category->id . '/' . $category->name) }}" >
                <figure>
                    <img src="{{ asset('/storage/'. $category->image) }}" alt="Image" class="img-fluid" style="width: 100%;">
                    <figcaption class="d-flex align-items-left justify-content-left">
                        <h2 class="caption">{{ $category->name }}</h2>
                    </figcaption>
                </figure>
            </a>
        </div>
        @endif
        @endforeach
        </div>


    <!-- row -->

</div>


@endsection
