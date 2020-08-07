<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountsController extends Controller
{
    /**
     * Search for specified resource by name.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $account = Account::where('name', 'LIKE', '%'.$request->search_name.'%')->first();
        if($account) {
            return redirect('/accounts/'. $account->id . '/edit');
        } else {
            return redirect('/home')->with(
                [
                    'error' => 'No account found'
                ]
            );
        }
    }

     /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all users
        $accounts = Account::all();

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'accounts' => $accounts
            ], 201);
        } else {
            //View w/ Data
            return view('accounts.index')->with(
                [
                    'accounts' => $accounts
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
        return view('accounts.create');
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
            'name' => 'required',
            'phone' => 'max:12',
            'fax' => 'max:12',
            'description' => 'max:255',
            'billing_address' => 'max:255',
            'billing_city' => 'max:255',
            'billing_state' => 'max:2',
            'billing_zip' => 'max:10',
            'billing_country' => 'max:255',
            'shipping_address' => 'max:255',
            'shipping_city' => 'max:255',
            'shipping_state' => 'max:2',
            'shipping_zip' => 'max:10',
            'shipping_country' => 'max:255',
        ]);

        // Update existing product
        $account = new Account;
        $account->name = $request->name;
        $account->phone = str_replace('-', '', $request->phone);
        $account->fax = str_replace('-', '', $request->fax);
        $account->website = $request->website;
        $account->industry = $request->industry;
        $account->company_size = $request->company_size;
        $account->annual_revenue = $request->annual_revenue;
        $account->description = $request->description;
        $account->billing_address = $request->billing_address;
        $account->billing_city = $request->billing_city;
        $account->billing_state = $request->billing_state;
        $account->billing_zip = $request->billing_zip;
        $account->billing_country = $request->billing_country;
        $account->shipping_address = $request->shipping_address;
        $account->shipping_city = $request->shipping_city;
        $account->shipping_state = $request->shipping_state;
        $account->shipping_zip = $request->shipping_zip;
        $account->shipping_country = $request->shipping_country;
        $account->save();

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'success' => 'Account Saved',
                'account' => $account
            ], 201);
        } else {
            //View w/ Data
            return redirect("/accounts/" . $account->id . "/edit")->with(
                [
                    'success' => 'Account saved!'
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
        $account = Account::find($id);

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'account' => $account
            ], 201);
        } else {
            //VIEW DATA
            return view('accounts.show')->with(
                [
                    'account' => $account
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
        $account = Account::find($id);

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'account' => $account
            ], 201);
        } else {
            //VIEW DATA
            return view('accounts.edit')->with(
                [
                    'account' => $account
                ]
            );
        }
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
            'phone' => 'max:12',
            'fax' => 'max:12',
            'description' => 'max:255',
            'billing_address' => 'max:255',
            'billing_city' => 'max:255',
            'billing_state' => 'max:2',
            'billing_zip' => 'max:10',
            'billing_country' => 'max:255',
            'shipping_address' => 'max:255',
            'shipping_city' => 'max:255',
            'shipping_state' => 'max:2',
            'shipping_zip' => 'max:10',
            'shipping_country' => 'max:255',
        ]);

        // Update existing product
        $account = Account::find($id);
        $account->name = $request->name;
        $account->phone = str_replace('-', '', $request->phone);
        $account->fax = str_replace('-', '', $request->fax);
        $account->website = $request->website;
        $account->industry = $request->industry;
        $account->company_size = $request->company_size;
        $account->annual_revenue = $request->annual_revenue;
        $account->description = $request->description;
        $account->billing_address = $request->billing_address;
        $account->billing_city = $request->billing_city;
        $account->billing_state = $request->billing_state;
        $account->billing_zip = $request->billing_zip;
        $account->billing_country = $request->billing_country;
        $account->shipping_address = $request->shipping_address;
        $account->shipping_city = $request->shipping_city;
        $account->shipping_state = $request->shipping_state;
        $account->shipping_zip = $request->shipping_zip;
        $account->shipping_country = $request->shipping_country;
        $account->save();

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'success' => 'Account Updated',
                'account' => $account
            ], 201);
        } else {
            //View w/ Data
            return redirect("/accounts/" . $id . "/edit")->with(
                [
                    'updated' => 'Account updated!'
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
        $account = Account::find($id);
        $account->delete();

        // After deleteing redirect back to object index
        return redirect('/accounts')->with('success', 'Account Removed!');
    }
}
