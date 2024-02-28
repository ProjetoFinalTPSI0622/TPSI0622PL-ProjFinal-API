<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Requests\UserInfoStoreRequest;
use App\User;
use App\UserInfo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (Auth::guard('api')->user()->hasRole('admin')) { // Check if user is admin

            $myUser = User::find($request->user_id);

            $messages = [
                'user_id.required' => 'O id do utilizador é obrigatório',
                'user_id.integer' => 'O id do utilizador deve ser um número inteiro',
                'user_id.exists' => 'O id do utilizador não existe',
                'class.max' => 'A turma deve ter menos de 255 caracteres',
                'nif.required' => 'O NIF é obrigatório',
                'nif.unique' => 'O NIF já existe',
                'nif.regex' => 'O NIF deve ter 9 dígitos',
                'birthday_date.required' => 'A data de nascimento é obrigatória',
                'birthday_date.date' => 'A data de nascimento deve ser uma data',
                'gender.integer' => 'O género deve ser um número inteiro',
                'gender.exists' => 'O género não existe',
                'phone_number.regex' => 'O número de telefone deve ter o formato +351123456789 ou 123456789',
                'address.max' => 'A morada deve ter menos de 255 caracteres',
                'postal_code.regex' => 'O código postal deve ter o formato 1234-123',
                'city.max' => 'A cidade deve ter menos de 30 caracteres',
                'district.max' => 'O distrito deve ter menos de 30 caracteres',
                'country.integer' => 'O país deve ser um número inteiro',
                'country.exists' => 'O país não existe',
            ];

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer|exists:users,id',
                'class' => 'sometimes|max:255',
                'nif' => 'required|unique:user_infos|regex:/^[0-9]{9}$/',
                'birthday_date' => 'required|date',
                'gender' => 'nullable|integer|exists:genders,id',
                'phone_number' => ['nullable', 'regex:/^(\+\d{12}|\d{9})$/'],
                'address' => 'sometimes|max:255',
                'postal_code' => 'nullable|regex:/^\d{4}-\d{3}$/',
                'city' => 'sometimes|max:30',
                'district' => 'sometimes|max:30',
                'country' => 'nullable|integer|exists:countries,id',
            ], $messages);

            if ($validator->fails()) {
                if ($myUser != null) {
                    $myUser->roles()->detach();
                    $myUser->delete();
                }
                return response()->json([
                    'message' => 'Os dados segintes estao invalidos.',
                    'errors' => $validator->errors(),
                ], 500);
            }

            try {
                $path = 'defaultImageUsers/DefaultUser.png';

                if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                    $file = $request->file('avatar');
                    $path = Storage::disk('public')->put('Users', $file);
                }
            } catch (Exception $e) {
                if ($myUser != null) {
                    $myUser->roles()->detach();
                    $myUser->delete();
                }
                return response()->json($e->getMessage(), 500);
            }

            try {
                $validatedData = $validator->validated();

                $userInfo = UserInfo::create([
                    'user_id' => $validatedData['user_id'],
                    'class' => $validatedData['class'] ?? null,
                    'nif' => $validatedData['nif'],
                    'birthday_date' => Carbon::createFromFormat('d-m-Y', $validatedData['birthday_date'])->toDateString(),
                    'gender_id' => $validatedData['gender'] ?? null,
                    'profile_picture_path' => $path,
                    'phone_number' => $validatedData['phone_number'] ?? null,
                    'address' => $validatedData['address'] ?? null,
                    'postal_code' => $validatedData['postal_code'] ?? null,
                    'city' => $validatedData['city'] ?? null,
                    'district' => $validatedData['district'] ?? null,
                    'country_id' => $validatedData['country'] ?? null,
                ]);

                return response()->json($userInfo, 200);

            } catch (Exception $e) {
                if ($myUser != null) {
                    $myUser->roles()->detach();
                    $myUser->delete();
                }
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
    public function update(UpdateUserInfoRequest  $request, UserInfo $userInfo)
    {
        if (Auth::guard('api')->user()->hasRole('admin') || Auth::guard('api')->user()->id == $userInfo->user_id) {

                $validatedData = $request->validated();

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
