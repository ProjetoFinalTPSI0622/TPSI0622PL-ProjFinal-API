<?php

namespace App\Http\Controllers;

use App\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $countries = Countries::all();
            return response()->json($countries, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
