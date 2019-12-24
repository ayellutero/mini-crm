@extends('layouts.app')

@section('styles')
<style>
img.logo-preview {
    max-width: -webkit-fill-available !important;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex bd-highlight">
                        <div class="flex-grow-1">{{ $company->name }}</div>
                        <div><a href="{{ route('companies.index') }}" class="btn btn-sm btn-outline-secondary text-right" data-toggle="tooltip" data-placement="bottom" title="Back to Companies">Back</a></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <img class="company-logo" src="{{ asset('storage/' . $company->logo) }}" alt="company-logo"/>
                        </div>
                        <div class="col-8 d-flex flex-column bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <span class="text-small d-block"><i class="fas fa-envelope"></i> <span class="company-email">{{ $company->email }}</span></span>
                                <span class="text-small d-block"><i class="fas fa-globe"></i> <span class="company-website">{{ $company->website }} </span></span>
                            </div>
                        </div>
                    </div>
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
});
</script>
@endsection