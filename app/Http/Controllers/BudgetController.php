<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    // store method
    public function store(Request $request)
    {
        // validate incoming request
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'limit_amount' => "required|numeric|min:0.01",
            'month' => 'required|integer',
            'year' => 'required|integer'
        ]);

        // find existing budget
        $exist = Budget::where('user_id', $request->user()->id)
            ->where('category_id', $request->category_id)
            ->where('month', $request->month)
            ->where('year', $request->year)
            ->exists();

        // if found then return 422
        if ($exist) {
            return response()->json([
                'message' => 'Budget already exists for this category and period'
            ], 422);
        }

        // create budget
        $budget = Budget::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'limit_amount' => $request->limit_amount,
            'month' => $request->month,
            'year' => $request->year
        ]);

        // return response
        return response()->json($budget->load('category'), 201);
    }

    // index method
    public function index(Request $request)
    {
        // budget list
        $budgets = Budget::where('user_id', $request->user()->id)
            ->with('category')
            ->get();

        // return response
        return response()->json($budgets, 200);
    }

    // update method
    public function update(Request $request, $id)
    {
        // validate incoming request
        $request->validate([
            'limit_amount' => "sometimes|numeric|min:0.01",
            'month' => 'sometimes|integer',
            'year' => 'sometimes|integer'
        ]);

        // find budget
        $budget = Budget::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        // if not found then return 403
        if (!$budget) {
            return response()->json([
                'message' => 'Budget not found'
            ], 403);
        }

        // update budget
        $budget->update(array_filter([
            'limit_amount' => $request->limit_amount,
            'month' => $request->month,
            'year' => $request->year
        ]));

        // return response
        return response()->json($budget->load('category'), 200);
    }

    // destroy method
    public function destroy(Request $request, $id)
    {
        // find budget
        $budget = Budget::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        // if not found then return 403
        if (!$budget) {
            return response()->json([
                'message' => 'Budget not found'
            ], 403);
        }

        //delete budget
        $budget->delete();

        //return response
        return response()->json([
            'message' => "Budget deleted!"
        ], 200);
    }
}
