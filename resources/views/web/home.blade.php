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
        <div class="col-xl-2 col-lg-3 col-md-5 col-sm-5 col-12 diffScreen" style="margin-bottom: 1%;">
            <a href="{{ url('collections/' . $category->id . '/' . $category->name) }}" >
                <figure>
                    <img oncontextmenu=return!1 src="{{ url('/storage/'. $category->image) }}" alt="Image" class="img-fluid" style="width: 100%;">
                    <figcaption class="d-flex align-items-left justify-content-left">
                        <h2 class="caption">{{ $category->name }}</h2>
                    </figcaption>
                </figure>
            </a>
        </div>
        @endif
        @endforeach
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
