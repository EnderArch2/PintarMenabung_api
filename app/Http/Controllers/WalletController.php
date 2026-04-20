<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    /**
     * GET /api/wallets
     */
    public function index(Request $request)
    {
        $wallets = $request->user()->wallets()->with('currency')->get();

        $formattedWallets = $wallets->map(function ($wallet) {
            return [
                'id' => $wallet->id,
                'user_id' => $wallet->user_id,
                'name' => $wallet->name,
                'created_at' => $wallet->created_at,
                'updated_at' => $wallet->updated_at,
                'currency_code' => $wallet->currency->code ?? null,
                'balance' => $this->calculateBalance($wallet)
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Get all wallets successful',
            'data' => [
                'wallets' => $formattedWallets
            ]
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * POST /api/wallets
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'currency_code' => 'required|exists:currencies,code',
        ], [
            'currency_code.exists' => 'The selected code is invalid.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ], 422);
        }

        $currency = Currency::where('code', $request->currency_code)->first();
        $wallet = $request->user()->wallets()->create([
            'name' => $request->name,
            'currency_id' => $currency->id
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Wallet added successful',
            'data'    => [
                'name'          => $wallet->name,
                'user_id'       => $wallet->user_id,
                'updated_at'    => $wallet->updated_at,
                'created_at'    => $wallet->created_at,
                'id'            => $wallet->id,
                'currency_code' => $currency->code,
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $wallet = Wallet::with('currency')->find($id);

        if (!$wallet) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not Found'
            ], 404);
        }

        if ($wallet->user_id !== $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden Access',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Get detail wallet successful',
            'data' => [
                'id'            => $wallet->id,
                'user_id'       => $wallet->user_id,
                'name'          => $wallet->name,
                'updated_at'    => $wallet->updated_at,
                'created_at'    => $wallet->created_at,
                'deleted_at'    => $wallet->deleted_at,
                'currency_code' => $wallet->currency->code ?? null,
                'balance' => $this->calculateBalance($wallet),
            ]
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    private function calculateBalance(Wallet $wallet)
    {
        // When you complete Part D (Transactions), you can replace this with a real query.
        // Example:
        // $income = $wallet->transactions()->whereHas('category', function($q) { $q->where('type', 'INCOME'); })->sum('amount');
        // $expense = $wallet->transactions()->whereHas('category', function($q) { $q->where('type', 'EXPENSE'); })->sum('amount');
        // return $income - $expense;

        return 0;
    }
}
