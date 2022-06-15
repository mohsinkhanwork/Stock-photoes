@extends('layouts.web.app')
@section('content')

<div class="row">
    <div class="col-md-12">
<nav aria-label="breadcrumb">
<ol class="breadcrumb" style="padding-top: 20px;padding-left: 2%;border-bottom: 1px solid lightgray;">
<li class="breadcrumb-item">
    <a href="http://127.0.0.1:8000" style="color: black">Home</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="http://127.0.0.1:8000/pages/contact" style="color: black">Contact Us</a>
</li>
</ol>
</nav>

<div class="row-md-12" style="margin-top: 2%;">
<div class="row">
<div class="col" style="/* border-radius: 100px; */margin-left: 2%;">
<h1 style="line-height: 29px;font-size: 21px;font-weight: 400; color: black;">Contact Us</h1>


<div class="col" style="padding-top: 25px;">
<div class="row col-md-12" style="margin-bottom: 2%;">
<div class="col-8">

    <p>
        Don’t hesitate to get in touch with us. We welcome any feedback that helps us improve our product
        collection and website. For questions regarding the copyright of our images or license agreement
        please refer to the information in the footer.
        </p>

</div>
<div class="col-4" style="text-align: right">
    DAY Investments Ltd.<br />
    6 Clayton Street <br />
    Newmarket <br />
    Auckland 1023 <br />
</div>
</div>






<form>
<div class="form-group row">

<div class="col-sm-12">
<input type="text" class="form-control" placeholder="Name" style="background-color: #E3E5E7;">
</div>
</div>
<div class="form-group row">

<div class="col-sm-12">
<input type="email" class="form-control" placeholder="Email" style="background-color: #E3E5E7;">
</div>
</div>


<div class="form-group row">

<div class="col-sm-12">
<textarea class="form-control" rows="5" id="comment" placeholder="Message" style="background-color: #E3E5E7;"></textarea>
</div>
</div><div class="form-group row">
<div class="col-sm-12" style="">
<button style="float: right;border-radius: 0;background: #03768F;" class="btn btn-primary btn-sm" type="submit">SEND</button>
</div>
</div>
</form>

</div>
</div><div class="col" style="text-align: right;">
<img src="https://cdn.shopify.com/s/files/1/3102/8110/files/nz-photos-contact-page-image.jpg?14597195113033344413" width="600px" height="400px" style="vertical-align: middle;
width: auto;
max-height: 370px;
border-radius: 50% 0 0 50%;">
</div>


</div></div>

</div></div>

@endsection
