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
    @foreach($companies as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>@isset($item->logo) <img class="logo-preview" src="{{ asset('storage/'.$item->logo) }}" alt="company-logo-preview" width=80/> @endisset</td>
            <td>{{ $item->website }}</td>
            <td>
                <div data-id="{{ $item->id }}" data-name="{{ $item->full_name }}">
                    <a href="#" class="btn py-0 view-action-btn" data-toggle="tooltip" data-placement="bottom" title="View"><i class="far fa-eye"></i></a>
                    @auth('web')
                    <a href="{{ route('companies.edit', $item->id) }}" class="btn py-0 edit-action-btn" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="far fa-edit"></i></a>
                    <a href="#" class="btn py-0 delete-action-btn" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="far fa-trash-alt"></i></a>
                    @endauth
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr class="mt-2">
<div class="col-12 d-flex p-0">
{{ isset($filters) ? $companies->appends($filters)->links() : $companies->links() }}
</div>