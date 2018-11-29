<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return new UserResource(User::all());

    }

    /**
     * verify requested user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, User $user)
    {
        //

        if ($result = $user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(["data" => $result]);



    }


}
