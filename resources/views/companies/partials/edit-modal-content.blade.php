<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title company-name" id="company-name">{{ $company->name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-4 text-center">
                    <img class="company-logo" src="{{ asset('storage/'. $company->logo) }}" alt="company-logo"/>
                </div>
                <div class="col-8 d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                        <span class="text-small d-block"><i class="fas fa-envelope"></i> <span class="company-email"> {{ $company->email }} </span></span>
                        <span class="text-small d-block"><i class="fas fa-globe"></i> <span class="company-website"> {{ $company->website }}</span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>