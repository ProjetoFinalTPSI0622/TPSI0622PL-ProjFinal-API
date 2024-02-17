<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInfoStoreRequest;
use App\User;
use App\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserInfoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserInfoStoreRequest $request)
    {
            if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin

                try {
                    $validatedData = $request->validated();
                    $path = 'defaultImageUsers/DefaultUser.png';

                    if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                        $file = $request->file('avatar');
                        $path = Storage::disk('public')->put('Users', $file);
                    }

                } catch (Exception $e) {
                    User::deleted($request->user_id);
                    return response()->json($e->getMessage(), 500);
                }

                try {
                    $userInfo = UserInfo::create([
                        'user_id' => $validatedData['user_id'],
                        'class' => $validatedData['class'],
                        'nif' => $validatedData['nif'],
                        'birthday_date' => Carbon::createFromFormat('d-m-Y', $validatedData['birthday_date'])->toDateString(),
                        'gender_id' => $validatedData['gender'],
                        'profile_picture_path' => $path,
                        'phone_number' => $validatedData['phone_number'],
                        'address' => $validatedData['address'],
                        'postal_code' => $validatedData['postal_code'],
                        'city' => $validatedData['city'],
                        'district' => $validatedData['district'],
                        'country_id' => $validatedData['country'],
                    ]);

                    return response()->json($userInfo, 200);
                } catch (Exception $e) {
                    User::deleted($request->user_id);
                    return response()->json($e->getMessage(), 500);
                }

            } else {
                return response()->json("Not authorized", 401);
            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UserInfo $userInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserInfo $userInfo)
    {
            if (Auth::guard('api')->user()->hasRole('admin') || Auth::guard('api')->user()->id == $userInfo->user_id) {

                try {
                    $request->merge(['birthday_date' => Carbon::createFromFormat('d-m-Y', $request->birthday_date)->toDateString()]);

                    $validatedData = $request->validate([
                        'user_id' => 'required|integer|exists:users,id',
                        'class' => 'sometimes|max:255',
                        'nif' => [
                            'required',
                            'size:9',
                            Rule::unique('user_infos')->ignore($userInfo->user_id, 'user_id'),
                        ],
                        'birthday_date' => 'required|date',
                        'gender_id' => 'nullable|integer|exists:genders,id',
                        'phone_number' => 'sometimes|max:13',
                        'address' => 'sometimes|max:255',
                        'postal_code' => 'sometimes|max:8',
                        'city' => 'sometimes|max:30',
                        'district' => 'sometimes|max:30',
                        'country_id' => 'nullable|integer|exists:countries,id',
                    ]);

                } catch (Exception $e) {

                    return response()->json($e->getMessage(), 500);
                }

                try {


                    if ($request->hasFile('file') && $request->file('file')->isValid()) {
                        $file = $request->file('file');

                        $defaultImagePath = 'defaultImageUsers/DefaultUser.png';
                        if ($userInfo->profile_picture_path != $defaultImagePath) {
                            Storage::disk('public')->delete($userInfo->profile_picture_path);
                        }

                        $path = Storage::disk('public')->put('Users', $file);
                        $validatedData['profile_picture_path'] = $path;
                    }
                } catch (Exception $e) {

                    return response()->json($e->getMessage(), 500);
                }
                $userInfo->update($validatedData);

                return response()->json($userInfo, 200);


            } else {
                return response()->json("Not authorized", 401);
            }
    }
}
