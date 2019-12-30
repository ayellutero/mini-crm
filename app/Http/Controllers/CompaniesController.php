<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyRequest;
use Exception;
use Illuminate\Http\Request;

class CompaniesController extends Controller
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
            $companies = Company::filter($filters)->paginate($pages);
        } else {
            $companies = Company::orderBy('name')->paginate(10);
        }
        $columns = (new Company)->getSortableDT();
        return view('companies.index', compact(
            'companies',
            'columns',
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
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('logo')) {
            // get the file name to be used after storing file in storage/app/public
            $filename = $request->file('logo')->hashName();
            // Store the contents to the storage/app/public
            $request->file('logo')->store('public');
            
            $data['logo'] = $filename;
        }
        
        // if Company is successfully created,
        if (Company::create($data)) {
            // redirect to Companies index page
            return redirect()->route('companies.index')->with(
                'message', [
                    'status' => 'success',
                    'text' => 'Successfully created a new company.'
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
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $prefix = request()->route()->getPrefix();
        if(isset($prefix) && $id === 'create') {
            // just to make sure that when an employee tries to access create page,
            // employee will be redirected to home page
            return redirect()->route('e.home');
        }
        
        try {

            $company = Company::find($id);
            // render partial page to be used in a modal for viewing company information
            $html = \View::make('companies.partials.show-modal-content', compact('company'))->render();

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
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);

        if ($company) {
            return view('companies.edit', compact('company'));
        }

        // else redirect back to index
        return redirect()->route('companies.index')->with(
            'message', [
                'status' => 'danger',
                'text' => 'Company not found.'
            ]
        ); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        $data = $request->all();
        $company = Company::find($id);

        if($company) {
            if ($request->hasFile('logo')) {
                // get the file name to be used after storing file in storage/app/public
                $filename = $request->file('logo')->hashName();
                // Store the contents to the storage/app/public
                $request->file('logo')->store('public');
                
                $data['logo'] = $filename;
            } else if (!isset($data['old_logo'])) {
                // if there's no uploaded file and old logo was removed
                $data['logo'] = null;            
            }
            
            // if Company is successfully updated,
            if (Company::find($id)->update($data)) {
                // redirect to Companies index page
                return redirect()->route('companies.index')->with(
                    'message', [
                        'status' => 'success',
                        'text' => 'Successfully updated company details.'
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

        // else redirect back to index
        return redirect()->route('companies.index')->with(
            'message', [
                'status' => 'danger',
                'text' => 'Company not found.'
            ]
        ); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        if($company) {
                if($company->delete()) {
                return redirect()->route('companies.index')->with(
                'message', [
                    'status' => 'success',
                    'text' => 'Successfully deleted data.'
                    ]
                ); 
            }

            return redirect('companies.index')->with(
                'message', [
                    'status' => 'danger',
                    'text' => 'There was an error deleting your data. Please try again.'
                ]
            ); 
        }

        // else redirect back to index
        return redirect()->route('companies.index')->with(
            'message', [
                'status' => 'danger',
                'text' => 'Company not found.'
            ]
        ); 
    }
}
