<?php

namespace App\Http\Controllers;

use App\Categories;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $categories = Categories::all();
            return response()->json($categories, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
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
                $category = Categories::create($request->all());
                return response()->json($category, 201);
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
     * @param \App\Categories $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $category)
    {
        if (Auth::guard('api')->user()->hasRole('admin')) {

            try {
                $category->update($request->all());
                return response()->json($category, 200);
            } catch (Exception $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else { // Return unauthorized response if not authenticated
            return response()->json("Not Enough Permissions", 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Categories $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $category)
    {
        if (Auth::guard('api')->user()->hasRole('admin')) {

            try {
                $category->delete();
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
