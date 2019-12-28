<div class="modal fade" id="export-employees-modal" tabindex="-1" role="dialog" aria-spanledby="export-employees-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <form class="form-horizontal" role="form" method="GET" action="{{ route('employees.export') }}" enctype="multipart/form-data" id="add_employee_form">
            <div class="modal-header pb-2 border-0">
                <span class="d-block h5 text-uppercase font-weight-bold company-name" id="company-name">Export employees</span>
            </div>
            <div class="modal-body pt-0">
                <div class="col-12 p-0">
                    <div class="row">
                        <label class="col">File type</label>
                        <div class="form-check col-4">
                            <input class="form-check-input" type="radio" name="file_type" value="csv" checked>
                            <label class="form-check-label">
                                CSV
                            </label>
                        </div>
                        <div class="form-check col-4">
                            <input class="form-check-input" type="radio" name="file_type" value="xlsx">
                            <label class="form-check-label">
                                XLSX
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col">Data</label>
                        <div class="form-check col-4">
                            <input class="form-check-input" type="radio" name="export_type" value="all" checked>
                            <label class="form-check-label">
                                All companies
                            </label>
                        </div>
                        <div class="form-check col-4">
                            <input class="form-check-input" type="radio" name="export_type" value="specific">
                            <label class="form-check-label">
                                Specific companies
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-12 px-0 export-companies-container d-none">
                        <select class="custom-select export-companies" name="export_companies[]" multiple disabled>
                            @foreach($companies as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary export-employees-btn">Export</button>
            </div>
        </form>
        </div>
    </div>
</div>