<?php

namespace App\Http\Controllers;

use App\CommentTypes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $commentTypes = CommentTypes::all();
            return response()->json($commentTypes, 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
