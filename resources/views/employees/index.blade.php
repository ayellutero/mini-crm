@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Employees</div>

                <div class="card-body">
                    <table class="table text-left text-nowrap table-sm">
                        <thead>
                            <tr>
                                <th class="text-left">Last Name</th>
                                <th class="text-left">First Name</th>
                                <th class="text-left">Company</th>
                                <th class="text-left">Email</th>
                                <th class="text-left">Phone</th>
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
@endsection

@section('scripts')
<script src="{{ asset('js/dt-pipeline.js') }}"></script>
<script type="text/template" id="actions-tmpl">
    <div class="text-right">
    <a href="#" class="btn py-0 text-right" data-toggle="tooltip" data-placement="bottom" title="View"><i class="far fa-eye"></i></a>
    <a href="#" class="btn py-0 text-right" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="far fa-edit"></i></a>
    <a href="#" class="btn py-0 text-right" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="far fa-trash-alt"></i></a>
    </div>
</script>
<script defer>
$(document).ready(function() {
    var template = _.template($('#actions-tmpl').html());
    $('.table').DataTable( {
        processing: true,
        serverSide: true,
        ajax: $.fn.dataTable.pipeline( {
            url: '/api/employees_dt',
        }),
        // ordering: false,
        columns: [
            {
                data: 'last_name' // naka map ito sa columns sa api mo
            },
            {
                data: 'first_name' // naka map ito sa columns sa api mo
            },
            {
                data: 'company_id' // naka map ito sa columns sa api mo
            },
            {
                data: 'email' // naka map ito sa columns sa api mo
            },
            {
                data: 'phone' // naka map ito sa columns sa api mo
            },
            {
                data: function(row) {
                    return template({
                        name: row.name
                    });
                },
                sortable: false
            }
        ]
    });

});
</script>
@endsection
