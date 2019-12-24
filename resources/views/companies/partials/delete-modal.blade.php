    <!-- Modal -->
<div class="modal fade" id="delete-company-modal" tabindex="-1" role="dialog" aria-labelledby="delete-company-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header pb-2 border-0">
                <span class="d-block h5 text-uppercase text-danger font-weight-bold"><i class="fas fa-times-circle"></i> Confirm Delete</span>
            </div>
            <div class="modal-body pt-0">
                This action will remove <span class="font-weight-bold text-uppercase company-name"></span> from your records and cannot be undone.
            </div>
            <div class="modal-footer">
                <form action="#" role="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>