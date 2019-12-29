@extends('layouts.app')

@section('styles')
<style>
#show-company-modal .company-logo {
    max-width: -webkit-fill-available !important;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Companies</div>
                <div class="card-body">
                    @if(Session::has('message'))
                    <div class="alert alert-{{ Session::get('message.status') }} alert-dismissible fade show" role="alert">
                        {{ Session::get('message.text') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <a href="{{ route('companies.create') }}" class="btn btn-outline-primary mb-3 add-item-btn" data-toggle="tooltip" data-placement="bottom" title="Add Company">Add Company</a>
                    <form action="{{ route('companies.index') }}">
                        <div class="row">
                            <div class="col-4 d-flex justify-content-start">
                                <div class="py-2 form-inline">
                                    <span class="text-small pr-2 ">Show </span>
                                    <input type="number" class="form-control w-25 rounded tbl-pages" id="tbl-pages" name="pages" placeholder="Page" min=10 step=5 value="{{ request()->get('pages') ? request()->get('pages') : 10 }}">
                                    <span class="text-small pl-2 "> entries </span>
                                </div>
                            </div>
                            <div class="col-8 d-flex justify-content-end">
                                <div>
                                    <span class="text-small pr-2 ">Sort by column</span>
                                    <select class="custom-select form-control tbl-sort-column" name="column">
                                        @foreach($columns as $item)
                                            <option value="{{ $item }}" @if(request()->get('column') && request()->get('column') === $item) selected @endif>{{ ucwords(str_replace(['_', 'id'], ' ', $item)) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="col-12 p-0">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input rounded-0 tbl-sort-order" type="radio" name="order" value="asc" checked>
                                            <label class="form-check-label">Ascending</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input tbl-sort-order" type="radio" name="order"value="desc" @if(request()->get('order') && request()->get('order') === 'desc') checked @endif>
                                            <label class="form-check-label ">Descending</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="px-2">
                                    <span class="text-small pr-2 ">Search by keyword</span>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control rounded tbl-keyword-search" id="tbl-keyword-search" name="keyword" placeholder="Type keyword" maxlength=250 value="{{ request()->get('keyword') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary rounded mx-2 tbl-filter-btn" type="submit" id="tbl-filter-btn">Apply</button>
                                            <a href="{{ route('companies.index') }}" class="btn btn-outline-primary rounded tbl-filter-btn" xid="tbl-reset-btn">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-container">
                    @include('companies.partials.datatable')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.delete-modal')
@include('partials.show-modal')
@endsection

@section('scripts')
<script defer>
$(document).ready(() => {
    var table = $('.table').DataTable({
        processing: true,
        info: false,
        ordering: false,
        paging: false,
        searching: false
    });

    $(document).on('click', '.view-action-btn', (e) => {
        var id = $(e.target).closest('div').data('id')
        var modal = $('#show-item-modal')
        $.ajax({
            url: '/companies/' + id,
            async: false,
            type: "GET",
            data: { id: id },
            dataType: "json",
            crossDomain: true,
            contentType: 'application/json',
            success: function(data) {
                modal.html(data.html)
                modal.modal('show')
            }
        });
    });

    $(document).on('click', '.delete-action-btn', (e) => {
        var id = $(e.target).closest('div').data('id')
        var name = $(e.target).closest('div').data('name')
        var modal = $('#delete-item-modal')

        modal.find('.item-name').text(name);
        modal.find('form').attr('action', window.location.origin + '/companies/' + id);
        modal.modal('show')
    });
});
</script>
@endsection
