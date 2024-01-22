<?php

namespace App\Http\Controllers;

use App\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
                $userInfos = UserInfo::all();
                return response()->json($userInfos, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
        }
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

        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

                try {

                    $validatedData = $request->validate([
                        'user_id' => 'required|integer',
                        'name' => 'required|max:255',
                        'nif' => 'required|size:9',
                        'birthday_date' => 'required|date',
                        'gender_id' => 'required|integer',
                        'phone_number' => 'required|max:13',
                        'address' => 'required|max:255',
                        'country_id' => 'required|integer',
                    ]);

                    if ($request->hasFile('file') && $request->file('file')->isValid()) {
                        $file = $request->file('file');
                        $path = Storage::disk('public')->put('Users', $file);
                    } else {
                        $path = asset('DefaultImageUsers/DefaultUser.png');
                    }

                    $validatedData['profile_picture_path'] = $path;
                    $validatedData['normalized_name'] = Str::upper($request['name']);

                    $userInfo = UserInfo::create($validatedData);
                    return response()->json($userInfo, 201);

                } catch (Exception $exception) {
                    return response()->json(['error' => $exception], 500);
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
     * Display the specified resource.
     *
     * @param  \App\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function show(UserInfo $userInfo)
    {
        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

                try {
                    $userInfo->profile_picture_path = Storage::url($userInfo->profile_picture_path);

                    return response()->json($userInfo, 200);
                } catch (Exception $exception) {
                    return response()->json(['error' => $exception], 500);
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInfo $userInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserInfo $userInfo)
    {
        try {
            $userInfo->update($request->all());
            return response()->json($userInfo, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInfo $userInfo)
    {

        if (Auth::guard('api')->check()) { // Check if user is logged in
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin TODO: change to admin

                try {
                    $defaultImagePath = 'DefaultImageUsers/DefaultUser.png';

                    $fullImagePath = storage_path('app/public/' . $userInfo->profile_picture_path);

                    if ($userInfo->profile_picture_path != $defaultImagePath && file_exists($fullImagePath)) {
                        Storage::disk('public')->delete($userInfo->profile_picture_path);
                    }

                    $userInfo->delete();
                    return response()->json(['message' => 'Deleted'], 205);
                } catch (Exception $exception) {
                    return response()->json(['error' => $exception], 500);
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
}
