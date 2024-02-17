<?php

namespace App\Http\Controllers;

use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('api')->user()->hasRole('admin')) {

            try {
                $roles = Roles::all();
                return response()->json($roles, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not Enough Permissions", 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('api')->user()->hasRole('admin')) {

            try {
                $role = Roles::create($request->all());
                return response()->json($role, 201);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not Enough Permissions", 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Roles $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roles $role)
    {
        if (Auth::guard('api')->user()->hasRole('admin')) {

            try {
                $role->update($request->all());
                return response()->json($role, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not Enough Permissions", 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Roles $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roles $role)
    {
        if (Auth::guard('api')->user()->hasRole('admin')) {

            try {
                $role->delete();
                return response()->json(['message' => 'Deleted'], 205);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else {
            // Return unauthorized response if not authenticated
            return response()->json("Not Enough Permissions", 401);
        }
    }
}
