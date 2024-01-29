<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    /**
     *  Authenticate User && Generate Token
     */
    public function userLogin(UserLoginRequest $request){
        try {

            $credentials = $request->validated();


            if(Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])){
                $user = Auth::user();

                try {
                    $token = $user->createToken('authToken')->plainTextToken;

                    $cookie = \Symfony\Component\HttpFoundation\Cookie::create("Bearer")
                        ->withValue($token)
                        ->withExpires(time() + 60 * 60)
                        ->withSecure(true)
                        ->withHttpOnly(true)
                        ->withSameSite("none")
                    ;
                } catch (Exception $e) {
                    return response()->json($e, 500);
                }
                return response()->json(['message' => 'Login Successful'], 200)->cookie($cookie);

            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }

        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function checkAuth(Request $request){
        try {
            if(Auth::guard('api')->check()){
                return response()->json(['auth' => true], 200);
            }
            else {
                return response()->json(['auth' => false], 200);
            }
        }
        catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}
