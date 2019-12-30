@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Company</div>

                <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert alert-{{ Session::get('message.status') }} alert-dismissible fade show" role="alert">
                        {{ Session::get('message.text') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data" id="edit_company_form">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="text-small font-weight-bold" for="name">Company Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $company->name }}" placeholder="Company name" maxlength=250>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="text-small font-weight-bold" for="email">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $company->email }}" placeholder="Company email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-small font-weight-bold" for="website">Website</label>
                                <input type="text" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ $company->website }}" placeholder="Website">
                                @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-12 px-0">
                            <label class="text-small font-weight-bold" for="logo">Company Logo</label>
                            <div class="input-group col-md-6 px-0 custom-file-container">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" name="logo">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                <div class="input-group-append remove-file-container @if(!isset($company->logo)) d-none @endif">
                                    <button class="btn remove-file-btn" type="button"><i class="fas fa-times text-danger"></i></button>
                                </div>
                                <input type="hidden" id="old_logo" name="old_logo" value="{{ $company->logo }}">
                            </div>
                            @error('logo')
                                <span class="custom-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 col-md-6 px-0 logo-preview-container @if(!isset($company->logo)) d-none @endif">
                            <label class="text-small font-weight-bold col-12 px-0" for="logo">Preview</label>
                            <img class="logo-preview" src="@isset($company->logo) {{ asset('storage/'.$company->logo) }} @else # @endif" alt="company-logo-preview" width=100/>
                        </div>
                        <hr class="mt-4">
                        <div class="text-center">
                            <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button href="#" class="btn btn-outline-info m-1 add-attendee-btn">Update</button>
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
    $(document).on('change', '.custom-file-input', (e) => {
        var el = $(e.target);
        preview_image(el)
    });

    $(document).on('click', '.remove-file-btn', (e) => {
        var el = $(e.target);
        $('#old_logo').removeAttr('value');
    });

});
</script>
@endsection