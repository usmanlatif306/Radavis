<div class="modal fade" id="commoditydeleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Are you Sure You wanted to Delete?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Delete" below if you want to delete commoditie!.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('commoditie-delete-form').submit();">
                    Delete
                </a>
                <form id="commoditie-delete-form" method="POST" action="{{ route('commoditie.destroy') }}">
                    @csrf
                    <input type = "hidden" value = "" id = "confirm_del_id" name = "commiditie_id">
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
