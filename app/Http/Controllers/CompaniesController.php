<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\App;

class CompaniesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all users
        $companies = Company::all();

        /**
         * If the path is api return data
         * else return view with data
         */
        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'companies' => $companies
            ], 201);
        } else {
            //View w/ Data
            return view('companies.index')->with(
                [
                    'companies' => $companies
                ]
            );
        }
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
    public function store(Request $request)
    {
         // Validate fields
         $this->validate($request, [
            'company' => 'required',
        ]);

        //Search to see if company exists
        $company = Company::where('name', 'LIKE', '%'.$request->company.'%')->first();
        //if found send company id to register
        if($company) {
            return view('auth.register')->with(
                [
                    'success' => 'Were you looking for ' . $company->name . '?',
                    'company_id' => $company->id
                ]
            );
        //else create a new company
        } else {
            // return $request;
            $company = new Company;
            $company->name = $request->company;
            $company->save();
            return view('auth.register')->with(
                [
                    'success' => 'Were you looking for ' . $company->name . '?',
                    'company_id' => $company->id
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $company = Company::find($id);
        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'company' => $company
            ], 201);
        } else {
            //View w/ Data
            return redirect("/companies/" . $id . "/edit")->with(
                [
                    'success' => 'Company updated!'
                ]
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $company = Company::find($id);
        return view('companies.edit')->with(
            [
                'company' => $company
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate fields
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required'
        ]);

        // Update existing product
        $company = Company::find($id);
        $company->name = $request->name;
        $company->address = $request->address;
        $company->save();

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'success' => 'Company Updated',
                'company' => $company
            ], 201);
        } else {
            //View w/ Data
            return redirect("/companies/" . $id . "/edit")->with(
                [
                    'success' => 'Company updated!'
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
