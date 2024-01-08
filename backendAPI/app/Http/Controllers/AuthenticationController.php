<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthenticationController extends Controller
{
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

                try {
                    $token = $user->createToken('authToken')->accessToken;
                    $cookie = Cookie::make('Bearer', $token, 60, '/', null, false, true);
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

        $bearerToken = $request->cookie('Bearer');
        $request->headers->set('Authorization', 'Bearer ' . $bearerToken);

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
