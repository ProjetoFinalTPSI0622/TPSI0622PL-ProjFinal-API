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
    public function index()
    {
        try {
            $genders = Genders::all();
            return response()->json($genders, 200);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
