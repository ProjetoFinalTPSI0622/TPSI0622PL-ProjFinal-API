<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\User;
use App\Roles;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('user')) { // Check if user is admin TODO: change to admin
                try {
                    // Retrieve all users
                    $users = User::all();

                    // Return the list of users
                    return response()->json($users, 200);
                } catch (Exception $e) {
                    // Handle exceptions if any
                    return response()->json($e->getMessage(), 500);
                }
            } else {
                // Return unauthorized response if not authenticated
                return response()->json("Not Enough Permissions", 401);
            }
        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not authenticated", 401);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if(Auth::guard('api')->check()){ // Check if user is logged in
            if(Auth::guard('api')->user()->hasRole('admin')){ // Check if user is admin
                try {

                    $validatedData = $request->validate([
                        'name' => 'required|max:255',
                        'email' => 'required|unique:users|max:255',
                        'password' => 'required|max:255',
                        'internalcode' => 'required|max:255',
                    ]);

                    $validatedData['password'] = Hash::make($validatedData['password']);

                    if($request->has('role')){
                        $role = Roles::where('role', $request->get('role'))->first();
                    }
                    else {
                        $role = Roles::where('role', 'user')->first();
                    }

                    $user = User::create($validatedData);
                    $user->roles()->attach($role);

                    return response()->json($user, 201);
                }
                catch (Exception $e) {
                    return response()->json($e, 500);
                }
            }
            else {
                return response()->json("Not authorized", 401);
            }
        }
        else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return JsonResponse
     */
    public function edit(User $user)
    {
        if (Auth::guard('api')->check()) {
            if (Auth::user()->hasRole('admin')) { // Check if user is admin
                try {
                    return response()->json($user, 200);
                } catch (Exception $e) {
                    return response()->json($e, 500);
                }
            } else {
                return response()->json("Not authorized", 401);
            }
        }
        else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user)
    {
        if(Auth::guard('api')->check()){ // Check if user is logged in
            if(Auth::user()->hasRole('admin')){ // Check if user is admin
                try {
                    $validatedData = $request->validate([
                        'name' => 'required|max:255',
                        'email' => 'required|max:255',
                        'password' => 'required|max:255',
                        'internalcode' => 'required|max:255',
                    ]);
                    $user->update($validatedData);
                    return response()->json($user, 200);
                }
                catch (Exception $e) {
                    return response()->json($e, 500);
                }
            }
            else {
                return response()->json("Not authorized", 401);
            }
        }
        else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        if(Auth::guard('api')->check()){ // Check if user is logged in
            if(Auth::user()->hasRole('admin')){ // Check if user is admin
                try {
                    $user->User::with('roles')->find($user->id)->roles()->detach();
                    return response()->json(['message' => 'User deleted'], 200);
                }
                catch (Exception $e) {
                    return response()->json($e, 500);
                }
            }
            else {
                return response()->json("Not authorized", 401);
            }
        }
        else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * get Authenticated User
     *
     */
    public function getAuthenticatedUser()
    {
        if(Auth::guard('api')->check()){ // Check if user is logged in
            try {
                $user = Auth::user();
                return response()->json($user, 200);
            }
            catch (Exception $e) {
                return response()->json($e, 500);
            }
        }
        else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
    * get user by ID
    *
    */
    public function search(Request $request) //search by either id name or email
    {
        if(Auth::guard('api')->check()){ // Check if user is logged in
            if(Auth::user()->hasRole('admin')){ // Check if user is admin
                try {
                    $search = $request->get('search');
                    $users = User::where('id', 'LIKE', '%'.$search.'%') //search by either id name or email
                        ->orWhere('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('email', 'LIKE', '%'.$search.'%')
                        ->get();
                    return response()->json($users, 200);
                }
                catch (Exception $e) {
                    return response()->json($e, 500);
                }
            }
            else {
                return response()->json("Not authorized", 401);
            }
        }
        else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     *  Authenticate User && Generate Token
     */
    public function userLogin(Request $request){
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if(Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])){
                $user = Auth::user();
                $token = $user->createToken('authToken')->accessToken;
                return response()->json(['user' => $user, 'token' => $token], 200);
            }
            else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }
        }
        catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}
