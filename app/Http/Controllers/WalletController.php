<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
