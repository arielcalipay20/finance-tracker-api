<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        // get user_id, month, and year
        $user_id = $request->user()->id;
        $month = now()->month;
        $year = now()->year;

        // income, expense, and net balance calculations
        $income = Transaction::where('user_id', $user_id)
            ->where('type', 'income')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $expense = Transaction::where('user_id', $user_id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $net_balance = ($income - $expense);

        // return response
        return response()->json([
            'income' => $income,
            'expense' => $expense,
            'net_balance' => $net_balance,
        ], 200);
    }
}
