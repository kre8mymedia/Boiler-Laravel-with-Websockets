<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Comment;
use App\Company;
use Mail;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($ticket_id)
    {
        // Get comments equal where the ticket ID equals
        $comments = Comment::where('ticket_id', $ticket_id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // Return tickets to api
        if (request()->is('api/*') == 1) {
            return response()->json([
                'comments' => $comments
            ], 201);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->is_public == 'on') {
            $is_public = true;
        } else {
            $is_public = false;
        }

        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->ticket_id = $request->ticket_id;
        $comment->body = $request->comment;
        $comment->is_public = $is_public;
        $comment->save();
        

        //Credentials to pass into subject body and from
        $passdata = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'ticket_id' => $comment->ticket_id
        ];

        //Send welcome email
        Mail::send('emails.new_comment', [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'company' => Company::where('id', auth()->user()->company_id)->first()->name,
            'ticket_id' => $comment->ticket_id,
            'is_public' => $is_public,
            'comment' => $comment->body
        ], function($message) use($passdata)
        {
            $message->from('help.animus@gmail.com', 'No-reply');
            $message->to('ryan.adaptivebiz@gmail.com');
            $message->subject("New comment on Ticket #" . $passdata['ticket_id'] . " from " . $passdata['email']);
        });

        if (request()->is('api/*') == 1) {
            //API DATA
            return response()->json([
                'success' => 'Ticket Saved',
                'comment' => $comment
            ], 201);
        } else {
            //View w/ Data
            return redirect("/tickets/" . $comment->ticket_id)->with(
                [
                    'success' => 'Comment saved!'
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
        // Find comment
        $comment = Comment::find($id);
        // Set ticket for redirect since delete comes first
        $ticket_id = $comment->ticket_id;
        // Delete the comment
        $comment->delete();

        // After deleteing redirect back to object index
        return redirect('/tickets/'. $ticket_id)->with('success', 'Comment Removed!');
    }
}
