<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInfoStoreRequest;
use App\UserInfo;
use Carbon\Carbon;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserInfoStoreRequest $request)
    {
        \Log::info($request->all());

        try {
            $validatedData = $request->validated();
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        try {
            $userInfo = UserInfo::create([
                'user_id' => $validatedData['user_id'],
                'nif' => $validatedData['nif'],
                'birthday_date' => Carbon::createFromFormat('d-m-Y', $validatedData['birthday_date'])->toDateString(),
                'gender_id' => $validatedData['gender'],
                'profile_picture_path' => $validatedData['profile_picture_path'] ?? 'defaultImageUsers/DefaultUser.png',
                'phone_number' => $validatedData['phone_number'],
                'address' => $validatedData['address'],
                'postal_code' => $validatedData['postal_code'],
                'city' => $validatedData['city'],
                'district' => $validatedData['district'],
                'country_id' => $validatedData['country'],
            ]);

            return response()->json($userInfo, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
/*
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                $path = Storage::disk('public')->put('Users', $file);
            } else {
                $path = 'defaultImageUsers/DefaultUser.png';
            }

            $validatedData['profile_picture_path'] = $path;

            return response()->json($userInfo, 201);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }*/

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
                    $userInfo->profile_picture_path = Storage::disk('public')->url($userInfo->profile_picture_path);

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

            $request->merge(['birthday_date' => Carbon::createFromFormat('d-m-Y', $request->birthday_date)->toDateString()]);

            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'class' => 'required|string',
                'nif' => 'required|size:9',
                'birthday_date' => 'required|date',
                'gender_id' => 'required|integer',
                'phone_number' => 'required|max:13',
                'address' => 'required|max:255',
                'postal_code' => 'required|max:8',
                'city' => 'required|max:255',
                'district' => 'required|max:255',
                'country_id' => 'required|integer',
            ]);

            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');

                $defaultImagePath = 'defaultImageUsers/DefaultUser.png';
                if ($userInfo->profile_picture_path != $defaultImagePath) {
                    Storage::disk('public')->delete($userInfo->profile_picture_path);
                }

                $path = Storage::disk('public')->put('Users', $file);
                $validatedData['profile_picture_path'] = $path;
            }

            $userInfo->update($validatedData);

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
                    $defaultImagePath = 'defaultImageUsers/DefaultUser.png';

                    if ($userInfo->profile_picture_path != $defaultImagePath && file_exists($userInfo->profile_picture_path)) {
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
