<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\Http\Requests\EmployeeRequest;
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
        if(!empty($request->all())) {
            $data = $request->all();
            $pages = isset($data['pages']) ? $data['pages'] : 10;
            $employees = Employee::filter($data)->paginate($pages);
            $employees->withPath(preg_replace('/&page=[0-9]*/', '', request()->getRequestUri()));
        } else {
            $employees = Employee::orderBy('last_name')->paginate(10);
        }
        $columns = (new Employee)->getSortableDT();
        
        return view('employees.index', compact(
            'employees',
            'columns'
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
        } catch (Exception $e) {
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

    public function filterTable(Request $request)
    {
        
        try {
            $data = $request->all();

            $employees = Employee::filter($data)->paginate($data['pages']);

            return  [
                'success' => true,
                'html' => route('employees.index', $data),
            ];
        } catch (Exception $e) {
            $message = $e->getMessage();
            return  [
                'success' => false,
            ];
        }

        return  [
            'success' => false,
        ];
        
    }
}
