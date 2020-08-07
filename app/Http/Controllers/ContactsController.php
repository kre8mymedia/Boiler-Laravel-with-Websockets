<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Account;

class ContactsController extends Controller
{
    /**
     * Search by Last Name Field.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // return $request;
        $contact = Contact::where('lastname', 'LIKE', '%'.$request->search_contact.'%')->first();
        
        if($contact) {
            return redirect('/contacts/'. $contact->id . '/edit');
        } else {
            return redirect('/home')->with(
                [
                    'error' => 'No contact found'
                ]
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all users
        $contacts = Contact::all();

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'contacts' => $contacts
            ], 201);
        } else {
            //View w/ Data
            return view('contacts.index')->with(
                [
                    'contacts' => $contacts
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
        $accounts = Account::all();
        return view('contacts.create')->with(
            [
                'accounts' => $accounts
            ]
        );
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
            'account_id' => 'required',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'office_phone' => 'max:12',
            'mobile' => 'max:12',
            'fax' => 'max:12',
            'email' => 'max:255',
            'title' => 'max:100',
            'report_to' => 'max:100',
            'department' => 'max:100',
            'home_phone' => 'max:12',
            'other_phone' => 'max:12',
            'assistant_name' => 'max:100',
            'assistant_phone' => 'max:12',
            'description' => 'max:255',
            'mailing_address' => 'max:255',
            'mailing_city' => 'max:100',
            'mailing_state' => 'max:2',
            'mailing_zip' => 'max:10',
            'mailing_country' => 'max:100',
            'in_touch_request_date' => 'date',
            'in_touch_save_date' => 'date',
            'birthdate' => 'date'
        ]);

        // Update existing product
        $contact = new Contact;
        $contact->account_id = $request->account_id;
        $contact->firstname = $request->firstname;
        $contact->middlename = $request->middlename;
        $contact->lastname = $request->lastname;
        $contact->office_phone = str_replace('-', '', $request->office_phone);
        $contact->mobile = str_replace('-', '', $request->mobile);
        $contact->fax = str_replace('-', '', $request->fax);
        $contact->email = $request->email;
        $contact->title = $request->title;
        $contact->report_to = $request->report_to;
        $contact->department = $request->department;
        $contact->home_phone = str_replace('-', '', $request->home_phone);
        $contact->other_phone = str_replace('-', '', $request->other_phone);
        $contact->assistant_name = str_replace('-', '', $request->assistant_name);
        $contact->assistant_phone = str_replace('-', '', $request->assistant_phone);
        $contact->description = $request->description;
        $contact->lead_source = $request->lead_source;
        $contact->lead_status = $request->lead_status;
        $contact->mailing_address = $request->mailing_address;
        $contact->mailing_city = $request->mailing_city;
        $contact->mailing_state = $request->mailing_state;
        $contact->mailing_zip = $request->mailing_zip;
        $contact->mailing_country = $request->mailing_country;
        $contact->in_touch_request_date = $request->in_touch_request_date;
        $contact->in_touch_save_date = $request->in_touch_save_date;
        $contact->birthdate = $request->birthdate;
        $contact->save();

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'success' => 'Contact Saved',
                'contact' => $contact
            ], 201);
        } else {
            //View w/ Data
            return redirect("/contacts/" . $contact->id . "/edit")->with(
                [
                    'success' => 'Contact saved!'
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
        $contact = Contact::find($id);

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'contact' => $contact
            ], 201);
        } else {
            //VIEW DATA
            return view('contacts.show')->with(
                [
                    'contact' => $contact
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
        $contact = Contact::find($id);
        $accounts = Account::all();
        return view('contacts.edit')->with(
            [
                'contact' => $contact,
                'accounts' => $accounts
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
            'account_id' => 'required',
            'firstname' => 'required|string',
            'middlename' => 'string',
            'lastname' => 'required|string',
            'office_phone' => 'max:12',
            'mobile' => 'max:12',
            'fax' => 'max:12',
            'email' => 'max:255',
            'title' => 'max:100',
            'report_to' => 'max:100',
            'department' => 'max:100',
            'home_phone' => 'max:12',
            'other_phone' => 'max:12',
            'assistant_name' => 'max:100',
            'assistant_phone' => 'max:12',
            'description' => 'max:255',
            'mailing_address' => 'max:255',
            'mailing_city' => 'max:100',
            'mailing_state' => 'max:2',
            'mailing_zip' => 'max:10',
            'mailing_country' => 'max:100',
            'in_touch_request_date' => 'date',
            'in_touch_save_date' => 'date',
            'birthdate' => 'date'
        ]);

        // Update existing product
        $contact = Contact::find($id);
        $contact->account_id = $request->account_id;
        $contact->firstname = $request->firstname;
        $contact->middlename = $request->middlename;
        $contact->lastname = $request->lastname;
        $contact->office_phone = str_replace('-', '', $request->office_phone);
        $contact->mobile = str_replace('-', '', $request->mobile);
        $contact->fax = str_replace('-', '', $request->fax);
        $contact->email = $request->email;
        $contact->title = $request->title;
        $contact->report_to = $request->report_to;
        $contact->department = $request->department;
        $contact->home_phone = str_replace('-', '', $request->home_phone);
        $contact->other_phone = str_replace('-', '', $request->other_phone);
        $contact->assistant_name = str_replace('-', '', $request->assistant_name);
        $contact->assistant_phone = str_replace('-', '', $request->assistant_phone);
        $contact->description = $request->description;
        $contact->lead_source = $request->lead_source;
        $contact->lead_status = $request->lead_status;
        $contact->mailing_address = $request->mailing_address;
        $contact->mailing_city = $request->mailing_city;
        $contact->mailing_state = $request->mailing_state;
        $contact->mailing_zip = $request->mailing_zip;
        $contact->mailing_country = $request->mailing_country;
        $contact->in_touch_request_date = $request->in_touch_request_date;
        $contact->in_touch_save_date = $request->in_touch_save_date;
        $contact->birthdate = $request->birthdate;
        $contact->save();

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'success' => 'Contact Updated',
                'contact' => $contact
            ], 201);
        } else {
            //View w/ Data
            return redirect("/contacts/" . $id . "/edit")->with(
                [
                    'updated' => 'Contact updated!'
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
        $contact = Contact::find($id);
        $contact->delete();

        // After deleteing redirect back to object index
        return redirect('/contacts')->with('success', 'Contact Removed!');
    }
}
