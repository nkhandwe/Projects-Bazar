<?php

namespace App\Http\Controllers\Payment_Methods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HDFCController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['message' => 'HDFC payment gateway is not available.'], 400);
    }
}
