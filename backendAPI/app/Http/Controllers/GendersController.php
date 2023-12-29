<?php

namespace App\Http\Controllers;

use App\Genders;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GendersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $genders = Genders::all();
            return response()->json($genders, 200);

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
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $gender = Genders::create($request->all());
            return response()->json($gender, 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genders  $genders
     * @return JsonResponse
     */
    public function show(Genders $gender)
    {
        try {
            return response()->json($gender, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Genders  $genders
     * @return \Illuminate\Http\Response
     */
    public function edit(Genders $genders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genders  $genders
     * @return JsonResponse
     */
    public function update(Request $request, Genders $gender)
    {
        try {
            $gender->update($request->all());
            return response()->json($gender, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genders  $genders
     * @return JsonResponse
     */
    public function destroy(Genders $gender)
    {
        try {
            $gender->delete();
            return response()->json(['message' => 'Deleted'], 205);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
