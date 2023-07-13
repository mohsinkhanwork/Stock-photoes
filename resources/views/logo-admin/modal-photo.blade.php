<div class="modal fade" id="adominoModal"
@if(!isset($tabIndexFalse)) tabindex="-1" @endif role="dialog" style="z-index: 99999999999;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div style="text-align: right;padding: 10px 15px 0px 10px;">
                <span data-dismiss="modal" style="font-size: 22px;cursor: pointer;">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
            </div>
            <div class="modal-body" style="display: flex; justify-content: center; align-items: center; height: 80vh;">
                <img src="{{ asset('/images/version_photos/'.$Vphoto->image) }}"
                     alt=""
                     style="max-height: 100%; max-width: 100%; object-fit: contain;"
                     class="img-fluid">
            </div>
        </div>
    </div>
</div>
