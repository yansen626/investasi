
<!-- Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="padding-top:10%;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="comment-form" method="POST" action="{{ route('get-prospectus') }}">
                {{ csrf_field() }}
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Penarikan Dana</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="widget-title ">
                            <h4>Apakah Anda yakin untuk menarik dana sebesar <br> Rp <span id="withdraw-amount">x</span></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-error" data-dismiss="modal">Tutup</button>
                    <button type="button" onclick="modalWalletWithdrawSubmit()" class="btn btn-solid">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
</div>