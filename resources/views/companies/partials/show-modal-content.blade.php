<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header pb-2 border-0">
            <span class="d-block h5 text-uppercase font-weight-bold company-name" id="company-name">{{ $company->name }}</span>
        </div>
        <div class="modal-body pt-0">
            <div class="row">
                <div class="col-4 text-center">
                    @isset($company->logo)<img class="company-logo" src="{{ asset('storage/'. $company->logo) }}" alt="company-logo"/>@endif
                </div>
                <div class="col-8 d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                        <span class="text-small d-block"><i class="fas fa-envelope"></i> <span class="company-email @if(!isset($company->email)) font-italic @endif"> {{ isset($company->email) ? $company->email : 'No email provided.' }} </span></span>
                        <span class="text-small d-block"><i class="fas fa-globe"></i> <span class="company-website @if(!isset($company->website)) font-italic @endif"> {{ isset($company->website) ? $company->website : 'No website provided.' }}</span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>