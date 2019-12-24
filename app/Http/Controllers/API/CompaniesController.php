<?php

namespace App\Http\Controllers\API;

use App\Company;
use App\Http\Controllers\Controller;
use App\Utilities\DataTable;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompanies()
    {
        try {
            $companies = Company::all();
            return response()->json([
                'success' => true,
                'companies' => $companies
            ]);    

        } catch (QueryException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        return [
            'success' => false,
            'message' => $error
        ];
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function getCompany(Request $request)
    {
        try {
            $id = $request->id;
            $company = Company::find($id);
            return response()->json([
                'success' => true,
                'company' => $company
            ]);    
        } catch (QueryException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        return [
            'success' => false,
            'message' => $error
        ];
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

    /**
     * For datatable
     */
    public function getData(Request $request)
    {
        $data = $request->all();
        $builder = Company::where('id', '<>', null);
        $table_columns = ['name', 'email', 'logo', 'website'];
        $columns = ['id', 'name', 'email', 'logo', 'website'];
        return response()->json((new DataTable($data, $builder, $columns, $table_columns))->getResponse());
    }
}
