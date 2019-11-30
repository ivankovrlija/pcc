<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json($user, 200);
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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255',
            'password'   => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::find(auth('api')->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->full_name  = $request->first_name . ' ' . $request->last_name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->avatar      = $request->avatar;

        if (isset($request->password) && !empty($request->password)) {
            $user->password   = bcrypt($request->password);
        }

        if ( $user->save() ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error' ];
        }
        
        return response()->json($response, 200);
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

    public function avatar(Request $request)
    {
        if ($request->file('avatar')->isValid()) {
            //$path = $request->avatar->store('public/avatars');

            $avatar_name = $request->file('avatar')->getClientOriginalName();
            $path = $request->avatar->storeAs('avatars', $avatar_name, 'public_folder');
            $user = User::find(auth('api')->user()->id);
            $user->avatar = url('uploads/avatars/' . basename($path));

            if ( $user->save() ) {
                $response = [ 'status' => 'success' ];
            } else {
                $response = [ 'status' => 'error' ];
            }
        } else {
            $response = [ 'status' => 'error' ];
        }

        return response()->json($avatar_name, 200);
    }
}
