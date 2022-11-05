
<div class="modal fade" id="adominoModal"
@if(!isset($tabIndexFalse)) tabindex="-1" @endif role="dialog" style="z-index: 99999999999;">
<div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
       <div class="modal-header" style="padding-top: 5px; padding-bottom: 5px;">
           <h5 class="modal-title" id="defaultModalLabel">Unterkategorie löschen</h5>
       </div>
       <form action="{{route('delete-process-photo')}}" method="post">
        @csrf
        <div class="modal-body">
            <img src="{{ asset('/storage/photos/originalImage/'.$photo->original_image) }}" alt="" class="img-fluid">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm"
                    data-dismiss="modal">Okay</button>
        </div>
    </form>
   </div>
</div>
</div>


