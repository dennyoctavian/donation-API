<?php

namespace App\Http\Controllers;

use App\Models\Pray;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->role == "admin") {
            $transactions = Transaction::all();
        } else {
            $transactions = Transaction::where('user_id', $user->id);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transactions,
        ]);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'donation' => 'required|integer',
            'type' => 'required|string',
            'pray' => 'string'
        ]);

        //'donation', 'redeem'
        $user = Auth::user();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'campaign_id' => $id,
            'donation' => $request['donation'],
            'type' => $request['type'],
        ]);

        Pray::create([
            'user_id' =>  $user->id,
            'campaign_id' => $id,
            'pray' => $request['pray']
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $transaction,
        ]);
    }
}
