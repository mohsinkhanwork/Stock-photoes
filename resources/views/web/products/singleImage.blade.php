@extends('layouts.web.app')
@section('content')

<style>
    /* The container */
    .container {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;

    }

    /* Hide the browser's default radio button */
    .container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;

    }

    /* Create a custom radio button */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 25px;
      width: 25px;
      background-color: #eee;
      border-radius: 50%;
       border: 1px solid lightgrey;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
      background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked ~ .checkmark {
      background-color: white;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked ~ .checkmark:after {
      display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after {
        top: 8px;
    left: 8px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: blue;
    }


tr:hover {background-color: ghostwhite;}

.btn-primary:hover {
    background-color: darkgreen;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  width: 100%;
  max-width: 100%;
}

tr {

    font-weight: 600;
}

.nr {

    width: 20px;
}

.country {

    width: 20px;
}

.row tbody tr.highlight td {
    background-color: #efefef;
}


th, td {
    font-size: 15px;
    padding: 11px 3px 10px 5px;
}

td {
    padding: 5px
}

.details1 {
    display: block;
}


/* input[type=radio] {
height: 20px;
width: 20px;
vertical-align: middle;
} */
</style>
 <div class="tm-container-content row" style="background-color: white;">


             <div class="col-md-12">
    <nav aria-label="breadcrumb" style="border-bottom: solid 1px lightgray;margin-left: 2%;font-size: 15px;">
  <ol class="breadcrumb" style="padding-left: 0;margin-bottom: 0;background: none;">
    <li class="breadcrumb-item"><a href="{{ asset('/') }}" style="color: black;">Home</a></li>
    <li class="breadcrumb-item"><a href="#" style="color: black;">Newest</a></li>
    <li class="breadcrumb-item active" aria-current="page">Duck</li>
  </ol>
</nav>

  <div class="row" style="margin: 2%;">
     <div class="col-md-8" style="text-align: center;background-color: #efefef;">
        @foreach ($subcategory as $subcategorySingleImage )
        <img src="{{ asset( '/storage/subcategories/96dpiImagesForSub/'.$subcategorySingleImage->dpiImage) }}" style="width: 80%;">
        @endforeach
    </div>
    <div class="col-md-4" style="border: 1px solid lightgray;padding: 1%;">
        <p style="font-size: 17px;font-weight: 500;">
            Buy this stock image now…
        </p>
   <p style="border-bottom: 3px solid lightgray;padding-bottom: 10px;font-size: 17px;">Royalty free licenses</p>
   <table id="userTable">
    <tbody>
        <tr id="$52.00 XSmall">
          <td>
            <label class="container"> XSmall <br>
                <span class="details" style="font-size: 11px;display: none">
                    457 x 300 px 16.1 x 10.6 cm (72 dpi) 401.7 KB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>
          <td style="text-align: center;"> $52.00

          </td>

        </tr>
        <tr id="$100.00 Small">
          <td>
            <label class="container"> Small <br>
                <span class="details" style="font-size: 11px;display: none">
                    675 x 444 px 23.8 x 15.7 cm (72 dpi) 878 KB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>
          <td style="text-align: center;"> $100.00 </td>

        </tr>
        <tr id="$200.00 Medium">
          <td>
            <label class="container"> Medium <br>
                <span class="details" style="font-size: 11px;display: none">
                    1407 x 924 px 23.8 x 15.6 cm (150 dpi) 3.7 MB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>

          <td style="text-align: center;"> $200.00 </td>

        </tr>
        <tr id="$258.00 Large">
          <td>
            <label class="container"> Large <br>
                <span class="details" style="font-size: 11px;display: none">
                    2813 x 1847 px 23.8 x 15.6 cm (300 dpi) 14.9 MB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>

          <td style="text-align: center;"> $258.00 </td>

        </tr>
        <tr id="$331.00 XLarge">
          <td>
            <label class="container"> XLarge <br>
                <span class="details" style="font-size: 11px;display: none">
                    3750 x 2463 px 31.8 x 20.9 cm (300 dpi) 26.4 MB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>
          <td style="text-align: center;"> $331.00 </td>

        </tr>
        <tr id="$384.00 XXLarge">
          <td>
            <label class="container"> XXLarge <br>
                <span class="details" style="font-size: 11px;display: none">
                    5000 x 3284 px 42.3 x 27.8 cm (300 dpi) 47 MB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>
          <td style="text-align: center;"> $384.00 </td>

        </tr>
      </tbody>
  </table>

  <p style="text-align: center;">
    <button id="btnRowClick"  class="btn btn-primary"
    style="font-weight: 700;background-color: springgreen;color: black;border: 1px solid;
    width: 100%;border-radius: 77px;font-size: 18px;"> buy now &gt; </button>
</p>

<p style="text-align: center;">
    <button class="btn btn-primary" style="
    font-weight: 700;
    background-color: white;
    color: black;
    border: 1px solid;
    width: 100%;
    border-radius: 77px;font-size: 18px;">add to cart</button>
</p>

{{-- <input type="button" id="tst" value="OK" onclick="fnselect()" /> --}}

</div>

</div>



   </div>

  <div class="imageDetails col-sm-6" style="margin-left: 2%;">
    <table>
         <tbody>
        <tr>
            <td style="font-weight: bold;">IMAGE DETAILS</td>

         </tr>

         @foreach ($subcategory as $subcategorySingleImage )
         <tr>
            <td>Dimensions:</td>
            <td>
                {{ $subcategorySingleImage->width }} x {{ $subcategorySingleImage->height }} px
                {{-- |
                <?php
                    // $inchewidth = $subcategorySingleImage->width * 0.0104166667;
                    // $inchehight = $subcategorySingleImage->height * 0.0104166667;

                ?>
                {{ round($inchewidth, 2) }} x {{ round($inchehight, 2) }} inches
                |

                <?php
                    // $cmwidth = $subcategorySingleImage->width * 0.026458333;
                    // $cmheight = $subcategorySingleImage->height * 0.026458333;

                ?>

                {{ round($cmwidth, 2) }} x {{ round($cmheight, 2) }} cm --}}


            </td>
         </tr>
         <tr>
            <td>Width:</td>
            <td>{{ $subcategorySingleImage->width }} pixels</td>
         </tr>
         <tr>
            <td>Height:</td>
            <td>{{ $subcategorySingleImage->height }} pixels</td>
         </tr>
         <tr>
            <td>Resolutions:</td>
            <td> 72 dpi </td>
         </tr>
         {{-- <tr>
            <td>Vertical resolutions:</td>
            <td> 96 dpi </td>
         </tr> --}}
         {{-- <tr>
            <td>Bit depth:</td>
            <td> 24 </td>
         </tr> --}}

         @endforeach
      </tbody></table>

  </div>
</div>




             <!-- row -->

        <!-- container-fluid, tm-container-content -->

{{-- script for buy button --}}
        <script type="text/javascript">
          $(function() {
            $('#userTable').on('click', 'tbody tr', function(event) {
                $(this).addClass('highlight').siblings().removeClass('highlight');
                $(this).find('td input[type=radio]').prop('checked', true);



                //document.getElementById('details').style.display = 'block';


            });

            $('#btnRowClick').click(function(e) {
              var rows = getHighlightRow();
              if (rows != undefined) {
                // alert(rows.attr('id'));
              }
            });

            var getHighlightRow = function() {
              return $('table > tbody > tr.highlight');
            }

          });
        </script>

{{-- end buy button script --}}


@endsection
