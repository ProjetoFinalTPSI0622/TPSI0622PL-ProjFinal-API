<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAuthedUserRequest;
use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserStoreRequest;
use App\User;
use App\Roles;
use App\UserInfo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Events\NewUserEvent;
use Illuminate\Support\Facades\Storage;


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
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin
                try {
                    // Retrieve all users
                    $users = User::with('userInfo')->get();


                        $users->each(function ($user) {
                        $user->userInfo->profile_picture_path = Storage::disk('public')->url($user->userInfo->profile_picture_path);
                    });

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
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        if ($request->get('role') != null) {
            $role = Roles::where('id', $request->get('role'))->first();
        } else {
            $role = Roles::where('name', 'user')->first();
        }

        try {

            $validatedData = $request->validated();

            try{
                $user = new User([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                    'internalcode' => $validatedData['internalcode'],
                ]);
            } catch (Exception $e) {
                return response()->json($e->getMessage(), 500);
            }

            $user->setAttribute('normalized_name', strtoupper($validatedData['name']));

            $user->save();
            $user->roles()->attach($role);

            return response()->json($user->id, 200);

        } catch (Exception $e) {

            return response()->json($e->getMessage(), 500);
        }

    }

    public function show(User $user)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            try {
                $user->load('userInfo', 'roles');
                //converter data na formato d-m-Y
                $user->userInfo->birthday_date = date('d-m-Y', strtotime($user->userInfo->birthday_date));
                $user->userInfo->profile_picture_path = Storage::disk('public')->url($user->userInfo->profile_picture_path);
                return response()->json($user, 200);
            } catch (Exception $e) {
                return response()->json($e, 500);
            }
        } else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            try {
                $validatedData = $request->validate([
                    'name' => 'required|max:255',
                    'email' => 'required|max:255',
                    'internalcode' => 'required|max:255',
                ]);

                $roles = Roles::query()->where('id', $request->get('role'))->get();


                $user->roles()->sync($roles);
                \Log::info($user);

                $user->update($validatedData);
                return response()->json($user, 200);
            } catch (Exception $e) {
                return response()->json($e, 500);
            }

        } else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
           // if (Auth::user()->hasRole('admin')) { // Check if user is admin

                try {
                    $user->roles()->detach();

                    if ($user->userInfo) {
                        $defaultImagePath = 'defaultImageUsers/DefaultUser.png';
                        if ($user->userInfo->profile_picture_path != $defaultImagePath) {
                            Storage::disk('public')->delete($user->userInfo->profile_picture_path);
                        }

                        UserInfo::deleted($user->userInfo);
                    }

                    $user->delete();

                    return response()->json(['message' => 'User deleted'], 200);
                } catch (Exception $e) {
                    return response()->json($e->getMessage(), 500);
                }

           // } else {
           //     return response()->json("Not authorized", 401);
           // }
        } else {
            return response()->json("Not logged in", 401);
        }
    }

    /**
     * get user by ID
     *
     */
    public function search(Request $request) //search by either id name or email
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::user()->hasRole('user')) { // Check if user is admin
                try {
                    $search = $request->get('search');
                    $users = User::where('name', 'LIKE', '%' . $search . '%') //search by either name or email
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                        ->get();
                    return response()->json($users, 200);
                } catch (Exception $e) {
                    return response()->json($e, 500);
                }
            } else {
                return response()->json("Not authorized", 401);
            }
        } else {
            return response()->json("Not logged in", 401);
        }
    }

    public function getAuthedUser()
    {

        try {
            $user = Auth::guard('api')->user();
            return response()->json($user, 200);
        }
        catch (Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function getTechnicians()
    {
        try {
            $techncians = User::whereHas('roles', function ($q) {
                $q->where('name', 'technician');
            })->get();
            return response()->json($techncians, 200);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }

    }

    public function changePassword(UserChangePasswordRequest $request)
    {
            try {
                $validatedData = $request->validated();
                $user = Auth::guard('api')->user();

                if($validatedData['currentPassword'] == $validatedData['newPassword']){
                    return response()->json("New password cannot be the same as the current password", 401);
                }

                if(!Hash::check($validatedData['currentPassword'], $user->password)){
                    return response()->json("Current password is incorrect", 401);
                }

                $user->setAttribute('password', Hash::make($validatedData['newPassword']));

                $user->save();
                return response()->json($user, 200);
            } catch (Exception $e) {
                return response()->json($e, 500);
            }
    }

}
