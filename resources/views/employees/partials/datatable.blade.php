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
        @foreach($employees as $item)
            <tr>
                <td>{{ $item->last_name }}</td>
                <td>{{ $item->first_name }}</td>
                <td>{{ $item->company_name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>
                    <div data-id="{{ $item->id }}" data-name="{{ $item->full_name }}">
                        <a href="#" class="btn py-0 view-action-btn" data-toggle="tooltip" data-placement="bottom" title="View"><i class="far fa-eye"></i></a>
                        <a href="{{ route('employees.edit', $item->id) }}" class="btn py-0 edit-action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="far fa-edit"></i></a>
                        <a href="#" class="btn py-0 delete-action-btn" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="far fa-trash-alt"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="col-12 d-flex justify-content-center">
{{ $employees->links() }}
</div>