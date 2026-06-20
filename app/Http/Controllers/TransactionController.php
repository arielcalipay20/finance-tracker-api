<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // store method
    public function store(Request $request)
    {
        // validate incoming request
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
            'transaction_date' => 'required|date'
        ]);

        // find category own by authenticated user
        $category = Category::where('id', $request->category_id)
            ->where('user_id', $request->user()->id)
            ->first();

        // if not found
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 403);
        }

        // derived type
        $type = $category->type;

        // create transaction
        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'type' => $type,
            'amount' => $request->amount,
            'note' => $request->note,
            'transaction_date' => Carbon::parse($request->transaction_date)
        ]);

        // return response
        return response()->json($transaction->load('category'), 201);
    }

    // index method
    public function index(Request $request)
    {
        // transaction list
        $transactions = Transaction::where('user_id', $request->user()->id)
            ->with('category')
            ->get();

        // return response
        return response()->json($transactions, 200);
    }

    // update method
    public function update(Request $request, $id)
    {
        // validate incoming request
        $request->validate([
            'amount' => 'sometimes|numeric|min:0.01',
            'note' => 'sometimes|string|max:255',
            'transaction_date' => 'sometimes|date'
        ]);

        // find the transaction
        $transaction = Transaction::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        // if not found
        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 403);
        }

        // update transaction
        $transaction->update(array_filter([
            'amount' => $request->amount,
            'note' => $request->note,
            'transaction_date' => $request->transaction_date
        ]));

        // return response
        return response()->json($transaction->load('category'), 200);
    }

    public function destroy(Request $request, $id)
    {
        // find the transaction
        $transaction = Transaction::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        // if not found return 403
        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 403);
        }

        // delete transaction
        $transaction->delete();

        // return response
        return response()->json([
            'message' => 'Transaction deleted!'
        ], 200);
    }
}
