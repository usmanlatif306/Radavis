<div class="modal fade" id="bulletinDeleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Are you Sure You wanted to Delete?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Select "Delete" below if you want to delete Bulletin!.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('bulletin-delete-form').submit();">
                    Delete
                </a>
                <form id="bulletin-delete-form" method="POST" action="{{ route('bulletin.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" value="" id="confirm_bulletin_id" name="bulletin_id">
                </form>
            </div>
        </div>
    </div>
</div>
