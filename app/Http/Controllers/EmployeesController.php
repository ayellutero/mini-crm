<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\Exports\EmployeesExport;
use App\Http\Requests\EmployeeRequest;
use App\Imports\EmployeesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        if(!empty($filters)) {
            $pages = isset($filters['pages']) ? $filters['pages'] : 10;
            $employees = Employee::filter($filters)->paginate($pages);
        } else {
            $employees = Employee::orderBy('last_name')->paginate(10);
        }
        $columns = (new Employee)->getSortableDT();
        $companies = Company::orderBy('name')->get();
        
        return view('employees.index', compact(
            'employees',
            'columns',
            'companies',
            'filters'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        return view('employees.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('file_import')) {
            try {
                $new_employees = \Excel::toArray(new EmployeesImport, $request->file('file_import'));

                foreach($new_employees as $employee) {
                    foreach ($employee as $row) {
                        if (isset($row[2])) { // company name is not null
                            if (Company::whereName($row[2])->exists()) { // if company name exists,
                                // get id of company
                                $row[2] = Company::whereName($row[2])->pluck('id')->first();
                            } else { // company does not exist in records yet
                                $company = Company::create([
                                    'name' => $row[2]
                                ]);

                                $row[2] = $company->id;
                            }
                        }

                        // create new employee from row data,
                        Employee::create([
                            'first_name' => $row[0],
                            'last_name' => $row[1],
                            'company_id' => $row[2],
                            'email' => $row[3],
                            'phone' => $row[4]
                        ]);
                    }
                }

                return redirect()->route('employees.index')->with(
                    'message', [
                        'status' => 'success',
                        'text' => 'Successfully created new employees.'
                    ]
                );

            } catch (\Exception $e) {
                return redirect()->back()->with(
                    'message', [
                        'status' => 'danger',
                        'text' => 'There was an error reading your file. Please try again.'
                    ]
                );
            }
        }

        // if Employee is successfully created,
        if (Employee::create($data)) {
            // redirect to Employees index page
            return redirect()->route('employees.index')->with(
                'message', [
                    'status' => 'success',
                    'text' => 'Successfully created a new employee.'
                ]
            );
        }

        // else redirect back to create form
        return redirect()->back()->with(
            'message', [
                'status' => 'danger',
                'text' => 'There was an error saving your data. Please try again.'
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $employee = Employee::find($id);
            // render partial page to be used in a modal for viewing employee information
            $html = \View::make('employees.partials.show-modal-content', compact('employee'))->render();

            return  [
                'success' => true,
                'html' => $html,
            ];
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return  [
                'success' => false,
            ];
        }

        return  [
            'success' => false,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            $companies = Company::orderBy('name')->get();
            return view('employees.edit', compact(
                'employee',
                'companies'
            ));
        }

        // else redirect back to index
        return redirect()->route('employees.index')->with(
            'message', [
                'status' => 'danger',
                'text' => 'Employee not found.'
            ]
        ); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        $data = $request->all();
        $employee = Employee::find($id);

        if ($employee) {
            if (isset($data['password'])) { // if password is being updated
                
                if($employee->updatePassword($data['password'])) {
                    return redirect()->route('employees.index')->with(
                        'message', [
                            'status' => 'success',
                            'text' => 'Successfully updated employee password.'
                        ]
                    );
                }
                // else redirect back to update password form
                return redirect()->back()->with(
                    'message', [
                        'status' => 'danger',
                        'text' => 'There was an error saving your data. Please try again.'
                    ]
                );
            }

            // if Employee is successfully updated,
            if ($employee->update($data)) {
                // redirect to Employees index page
                return redirect()->route('employees.index')->with(
                    'message', [
                        'status' => 'success',
                        'text' => 'Successfully updated employee details.'
                    ]
                );
            }

            // else redirect back to edit form
            return redirect()->back()->with(
                'message', [
                    'status' => 'danger',
                    'text' => 'There was an error saving your data. Please try again.'
                ]
            );    
        }

        // else redirect back to index
        return redirect()->route('employees.index')->with(
            'message', [
                'status' => 'danger',
                'text' => 'Employee not found.'
            ]
        ); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        // if employee exists
        if ($employee) {
            if($employee->delete()) {
                return redirect()->route('employees.index')->with(
                'message', [
                    'status' => 'success',
                    'text' => 'Successfully deleted data.'
                    ]
                ); 
            }

            return redirect('employees.index')->with(
                'message', [
                    'status' => 'danger',
                    'text' => 'There was an error deleting your data. Please try again.'
                ]
            );     
        }

        // else redirect back to index
        return redirect()->route('employees.index')->with(
            'message', [
                'status' => 'danger',
                'text' => 'Employee not found.'
            ]
        ); 
        
    }
    
    /**
     * For exporting employees data
     */
    public function export(Request $request)
    {
        $data = $request->all();

        // check what type of data the user selected
        if ($data['export_type'] === 'all') {
            $export = new EmployeesExport(Employee::export()->get());
        } else {
            $export = new EmployeesExport(Employee::export($data['export_companies'])->get());
        }
    
        return \Excel::download($export, 'employees.' . $data['file_type']);
    }
}
