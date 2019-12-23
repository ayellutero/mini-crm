<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('companies.index');
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

        // dd(Company::find(1));
        $data = $request->all();

        // get the file name to be used after storing file in storage/app/public
        $filename = $request->file('logo')->hashName();
        // Store the contents to the storage/app/public
        $request->file('logo')->store('public');
        
        $data['logo'] = $filename;
        
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
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
