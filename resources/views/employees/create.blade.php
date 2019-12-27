@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
                        <hr class="mt-4">
                        <div class="text-center">
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button href="#" class="btn btn-outline-primary m-1 add-attendee-btn">Add</button>
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
});
</script>
@endsection