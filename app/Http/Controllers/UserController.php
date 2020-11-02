<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function searchUser(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->value . '%')->orWhere('username', 'like', '%' . $request->value . '%')->get();

        return response()->json($users);
    }
}
