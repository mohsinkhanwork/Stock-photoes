@extends('customer-portal.layout.customer')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">

            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dashboard</h3>
                    </div>
                    <div class="card-body">
                        
                     

      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

 
  
    <style>
        .image {
            margin-top: 10px;
        }
    </style>
 
</head>

    <div class="col-md-offset-4 col-md-4 col--md-offset-4 top">
        <div id="generateImg" style="border:1px solid;text-align:center;">
            <img src="{{ asset('/frontend/img/hero.jpg') }}" width="300px" height="200px">
            <h4> Everything written here will be converted to image below:</h4>
            <input id="txtbox" type="text" value="" placeholder="Enter text here!!..."  class="form-control" width="300" />
            <input id="txtbox" type="text" value="" placeholder="Enter text here!!..."  class="form-control" width="300" />
            <br />
        </div>
        <button id="generateimg" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Generate Image</button>
 
        

        <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
            
            <div id="img" style="display:none;margin-top: 20px;" >
            <img src=""  id="newimage" class="image" />
        </div>
        
        </div>
    </div>

          <script>
        $(function () {
            $("#generateimg").click(function () {
                html2canvas($("#generateImg"), {
                     
                    onrendered: function (canvas) {
                        var textBox = $.trim($('input[type=text]').val())
                       
                            var imgsrc = canvas.toDataURL("image/png");
                            {{--  console.log(imgsrc);  --}}
                            $("#newimage").attr('src', imgsrc);
                            $("#img").show();
 
                     
                        }
                         
                });
            });
        });
    </script>
    </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
