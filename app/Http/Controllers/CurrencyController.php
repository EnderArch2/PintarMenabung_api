<?php

namespace App\Http\Controllers;

use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Get all currencies successful',
            'data' => [
                'currencies' => $currencies
            ]
        ], 200);
    }
}
