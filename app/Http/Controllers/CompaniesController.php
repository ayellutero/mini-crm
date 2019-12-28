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
        if(!empty($request->all())) {
            $data = $request->all();
            $pages = isset($data['pages']) ? $data['pages'] : 10;
            $companies = Company::filter($data)->paginate($pages);
            $companies->withPath(preg_replace('/&page=[0-9]*/', '', request()->getRequestUri()));
        } else {
            $companies = Company::orderBy('name')->paginate(10);
        }
        $columns = (new Company)->getSortableDT();
        return view('companies.index', compact(
            'companies',
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

    /**
     * 
     * filter data in index table 
     * 
     */
    public function filterTable(Request $request)
    {
        try {
            $data = $request->all();
            return  [
                'success' => true,
                'html' => route('companies.index', $data),
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
