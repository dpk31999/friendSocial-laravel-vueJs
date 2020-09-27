<?php

namespace App\Http\Controllers;

use App\User;
use App\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Interest::all(), 200);
    }

    public function getPeople(User $user)
    {
        $people = collect();

        foreach($user->interests as $interest)
        {
            $people = $people->merge($interest->users);
        }

        $people = $people->unique('id');

        foreach($people as $key => $userV2)
        {
            if($userV2->id == $user->id)
            {
                $people->forget($key);
            }
        }

        return response()->json($people, 200);
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
     * @param  \App\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function showId(User $user)
    {
        $interests = $user->interests;

        return response()->json($interests->pluck('id'), 200);
    }

    public function show($username)
    {
        $user = User::where('username',$username)->first();
        return response()->json($user->interests, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->interests()->toggle($request->interests);

        return response()->json($user->interests->pluck('id'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interest $interest)
    {
        //
    }
}
