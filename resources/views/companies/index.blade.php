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
                    <a href="{{ route('companies.create') }}" class="btn btn-sm btn-outline-primary mb-3 add-item-btn" data-toggle="tooltip" data-placement="bottom" title="Add Company">Add Company</a>
                    <table class="table text-left text-nowrap table-sm">
                        <thead>
                            <tr>
                                <th class="text-left">Company</th>
                                <th class="text-left">Email</th>
                                <th class="text-left">Logo</th>
                                <th class="text-left">Website</th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('companies.partials.delete-modal')
@include('companies.partials.show-modal')
@endsection

@section('scripts')
<script src="{{ asset('js/dt-pipeline.js') }}"></script>

<!-- Template for actions column -->
<script type="text/template" id="actions-tmpl">
<div data-id="<%= id %>" data-name="<%= name %>">
    <a href="#" class="btn py-0 view-action-btn" data-toggle="tooltip" data-placement="bottom" title="View"><i class="far fa-eye"></i></a>
    <a href="/companies/<%= id %>/edit" class="btn py-0 edit-action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="far fa-edit"></i></a>
    <a href="#" class="btn py-0 delete-action-btn" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="far fa-trash-alt"></i></a>
</div>
</script>

<!-- Template for logo column -->
<script type="text/template" id="logo-tmpl">
    <% if (typeof(logo) === 'string') { %><img class="logo-preview" src="/storage/<%= logo %>" alt="company-logo-preview" width=80/><% } %>
</script>

<!-- Template for website column -->
<script type="text/template" id="website-tmpl">
    <a target="_blank" href="<%= website %>"><%= website %></a>
</script>

<script defer>
$(document).ready(() => {
    var actions_tmpl = _.template($('#actions-tmpl').html());
    var logo_tmpl = _.template($('#logo-tmpl').html());
    var website_tmpl = _.template($('#website-tmpl').html());

    var table = $('.table').DataTable( {
        processing: true,
        serverSide: true,
        ajax: $.fn.dataTable.pipeline( {
            url: '/api/companies_dt',
        }),
        columns: [
            {
                data: 'name'
            },
            {
                data: 'email'
            },
            {
                data: (row) => {
                    return logo_tmpl({
                        logo: row.logo
                    });
                },
                sortable: false
            },
            {
                data: (row) => {
                    return website_tmpl({
                        website: row.website
                    });
                },
                sortable: false
            },
            {
                data: (row) => {
                    return actions_tmpl({
                        name: row.name,
                        id: row.id
                    });
                },
                sortable: false
            }
        ],
        language: {
            search: '',
            searchPlaceholder: 'Search'
        }
    });

    $(document).on('click', '.view-action-btn', (e) => {
        var id = $(e.target).closest('div').data('id')
        var modal = $('#show-company-modal')
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
        var modal = $('#delete-company-modal')

        modal.find('.company-name').text(name);
        modal.find('form').attr('action', window.location.origin + '/companies/' + id);
        modal.modal('show')
    });
});
</script>
@endsection
