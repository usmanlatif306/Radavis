<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Are you Sure You wanted to Delete?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Select "Delete" below if you want to delete Truck!.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('via-delete-form').submit();">
                    Delete
                </a>
                <form id="via-delete-form" method="POST" action="{{ route('via.destroy') }}">
                    @csrf
                    <input type="hidden" value="" id="confirm_del_id" name="via_id">
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
