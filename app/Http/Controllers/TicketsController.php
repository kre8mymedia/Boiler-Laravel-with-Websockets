<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Comment;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'tickets' => $tickets
            ], 201);
        } else {
            //View w/ Data
            return view('tickets.index')->with(
                [
                    'tickets' => $tickets
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
        return view('tickets.create');
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
            'user_id' => 'required',
            'subject' => 'max:255',
            'body' => 'max:255',
            'status' => 'string',
        ]);

        $ticket = new Ticket;
        $ticket->user_id = $request->user_id;
        $ticket->subject = $request->subject;
        $ticket->body = $request->body;
        $ticket->status = $request->status;
        $ticket->save();

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'success' => 'Ticket Saved',
                'ticket' => $ticket
            ], 201);
        } else {
            //View w/ Data
            return redirect("/tickets")->with(
                [
                    'success' => 'Ticket saved!'
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
        $comments = Comment::where('ticket_id', $id)->orderBy('created_at', 'desc')->paginate(10);
        $ticket = Ticket::find($id);
        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'ticket' => $ticket,
                'comments' => $comments
            ], 201);
        } else {
            //VIEW DATA
            return view('tickets.show')->with(
                [
                    'ticket' => $ticket,
                    'comments' => $comments
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
        $ticket = Ticket::find($id);
        return view('tickets.edit')->with(
            [
                'ticket' => $ticket
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
            'user_id' => 'required',
            'subject' => 'max:255',
            'body' => 'max:255',
            'status' => 'string',
        ]);

        $ticket = Ticket::find($id);
        $ticket->user_id = $request->user_id;
        $ticket->subject = $request->subject;
        $ticket->body = $request->body;
        $ticket->status = $request->status;
        $ticket->save();

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'success' => 'Ticket updated',
                'ticket' => $ticket
            ], 201);
        } else {
            //View w/ Data
            return redirect("/tickets")->with(
                [
                    'updated' => 'Ticket updated!'
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
        $ticket = Ticket::find($id);
        $ticket->delete();

        // After deleteing redirect back to object index
        return redirect('/tickets')->with('success', 'Ticket Removed!');
    }
}
