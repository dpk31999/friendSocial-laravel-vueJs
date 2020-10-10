<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Pusher\Pusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Get a message from friend
     *
     * @return \Illuminate\Http\Response
     */
    public function getMessage($username,Request $request)
    {
        $id_auth = $request->user()->id;
        $id_user = User::where('username',$username)->first()->id;

        DB::table('messages')->where([
            ['from', '=', $id_user],
            ['to', '=', $id_auth],
        ])->update(['is_read' => 1]);

        $messages = Message::where(function ($query) use ($id_user,$id_auth){
            $query->where('from',$id_auth)->where('to',$id_user);
        })->orWhere(function($query) use($id_user,$id_auth){
            $query->where('from',$id_user)->where('to',$id_auth);
        })->get();

        return response()->json($messages, 200);

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
        $user_auth = $request->user();
        $user_received = User::where('username',$request->username_received)->first();

        $message = Message::create([
            'from' => $user_auth->id,
            'to' => $user_received->id,
            'message' => $request->message,
            'is_read' => 0
        ]);

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $pusher->trigger('channel-chat', 'event-chat', [
            'message' => $message,
            'user_from' => $user_auth,
            'user_to' => $user_received
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
