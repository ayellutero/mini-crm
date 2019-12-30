@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Employee</div>

                <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert alert-{{ Session::get('message.status') }} alert-dismissible fade show" role="alert">
                        {{ Session::get('message.text') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data" id="add_employee_form">
                    @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="text-small font-weight-bold" for="first-name">First Name</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first-name" name="first_name" value="{{ old('first_name') }}" placeholder="First name" maxlength=250>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-small font-weight-bold" for="last-name">Last Name</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last-name" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" maxlength=250>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="text-small font-weight-bold" for="email">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Employee email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-small font-weight-bold" for="phone">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Phone">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-12 px-0">
                            <label class="text-small font-weight-bold" for="company">Company</label>
                            <select class="custom-select form-control" name="company_id">
                                @foreach($companies as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <div class="col">
                                <hr>
                            </div>
                            <div class="flex-shrink-1 mt-1">
                                <label class="text-small font-weight-bold">OR</label>
                            </div>
                            <div class="col">
                                <hr>
                            </div>
                        </div>
                        <div class="form-group col-md-6 px-0">
                            <label class="text-small font-weight-bold m-0">Spreadsheet file</label>
                            <label><small>Note: File will be prioritized over a single input in the above form.</small></label>
                            <div class="input-group custom-file-container">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('file_import') is-invalid @enderror" name="file_import" accept=".xlsx, .csv">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                <div class="input-group-append remove-file-container d-none">
                                    <button class="btn remove-file-btn" type="button"><i class="fas fa-times text-danger"></i></button>
                                </div>
                            </div>
                            @error('file_import')
                                <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <hr class="mt-4">
                        <div class="text-center">
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button href="#" class="btn btn-outline-info m-1 add-attendee-btn">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script defer>
$(document).ready(() => {
    $('select').select2();
    $(document).on('change', '.custom-file-input', (e) => {
        var el = $(e.target);
        if(el[0].files.length === 0) {
            $('.remove-file-container').addClass('d-none');
        } else {
            $('.remove-file-container').removeClass('d-none');
        }
    });
});
</script>
@endsection