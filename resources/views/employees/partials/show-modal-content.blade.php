<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header pb-2 border-0">
            <span class="d-block h5 text-uppercase font-weight-bold company-name" id="company-name">{{ $employee->full_name }}</span>
        </div>
        <div class="modal-body pt-0">
            <div class="row">
                <div class="col-4 text-center">
                    <img class="avatart" src="{{ asset('images/avatar.png') }}" alt="avatar" width="100" height="100"/>
                </div>
                <div class="col-8 d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                        <span class="text-small d-block"><i class="far fa-building"></i> <span class="company-name @if(!isset($employee->company_id)) font-italic @endif"> {{ isset($employee->company_id) ? $employee->company_id : 'Not registered to any company.' }} </span></span>
                        <span class="text-small d-block"><i class="fas fa-envelope"></i> <span class="employee-email @if(!isset($employee->email)) font-italic @endif"> {{ isset($employee->email) ? $employee->email : 'No email provided.' }} </span></span>
                        <span class="text-small d-block"><i class="fas fa-phone"></i> <span class="employee-phone @if(!isset($employee->phone)) font-italic @endif"> {{ isset($employee->phone) ? $employee->phone : 'No website provided.' }}</span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>