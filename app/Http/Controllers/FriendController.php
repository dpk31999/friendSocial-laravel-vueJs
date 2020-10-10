<?php

namespace App\Http\Controllers;

use App\User;
use App\Friend;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{
    public $friends;

    public function __construct()
    {

    }

    public function getStatusFriend(Request $request,$username)
    {
        $userTarget = User::where('username',$username)->first();

        if($request->user()->friendRequest()->get()->contains('id',$userTarget->id) || $userTarget->friendRequest()->get()->contains('id',$request->user()->id)){
            return response()->json(['status' => '1'], 200);
        }
        else if($request->user()->requestFriend()->get()->contains('id',$userTarget->id))
        {
            return response()->json(['status' => '0'], 200);
        }
        else if($userTarget->requestFriend()->get()->contains('id',$request->user()->id))
        {
            return response()->json(['status' => 'special'], 200);
        }
        else {
            return response()->json(['status' => ''], 200);
        }
    }
    public function updateStatusFriend(Request $request,$id)
    {
        $userTarget = User::find($id);
        $user = $request->user();

        if($user->friendRequest()->get()->contains('id',$userTarget->id)){
            $user->friendRequest()->detach($userTarget->id);

            return response()->json(['status' => ''], 200);
        }
        else if($userTarget->friendRequest()->get()->contains('id',$user->id))
        {
            $userTarget->friendRequest()->detach($user->id);

            return response()->json(['status' => ''], 200);
        }
        else if($user->requestFriend()->get()->contains('id',$userTarget->id))
        {
            $user->requestFriend()->detach($userTarget);

            return response()->json(['status' => ''], 200);
        }
        else if($userTarget->requestFriend()->get()->contains('id',$user->id))
        {
            DB::table('friends')
                ->where([
                    ['from','=',$userTarget->id],
                    ['to','=',$user->id]
                ])->update(['status' => 1]);

            return response()->json(['status' => '1'], 200);
        }
        else{
            Friend::create([
                'from' => $user->id,
                'to' => $userTarget->id,
                'status' => '0'
            ]);

            return response()->json(['status' => '0'], 200);
        }
    }

    public function getCountFriend(Request $request,$username)
    {
        $userTarget = User::where('username',$username)->first();

        $count = DB::table('friends')
                ->where([
                    ['from','=',$userTarget->id],
                    ['status','=','1']
                ])->orWhere([
                    ['to','=',$userTarget->id],
                    ['status','=','1']
                ])->get()->count();
        
        return response()->json($count, 200);
    }

    public function getFriend(User $user,Request $request   )
    {
        $friendRequest = $user->friendRequest;

        $friendAccept = $user->friendAccept;

        $friends = $friendRequest->merge($friendAccept);

        foreach($friends as $friend)
        {
            $unread = Message::where([
                'from' => $friend->id,
                'to' => $request->user()->id,
                'is_read' => '0'
            ])->get()->count();
            $friend->unread = $unread;
        }

        return response()->json($friends, 200);
    }

    public function getRequest(User $user)
    {
        $inviteFriend = $user->inviteFriend;

        return response()->json($inviteFriend, 200);
    }

}
