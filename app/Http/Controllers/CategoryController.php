<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // store method
    public function store(Request $request)
    {
        // validate
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense'
        ]);

        // create category
        Category::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'type' => $request->type
        ]);

        // return response
        return response()->json([
            'message' => 'Category created!'
        ], 201);
    }

    // index method
    public function index(Request $request)
    {
        // category list
        $categories = Category::where('user_id', $request->user()->id)
            ->get();

        // return response
        return response()->json($categories, 200);
    }

    // update method
    public function update(Request $request, $id)
    {
        // validate incoming request
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:income,expense'
        ]);

        // find category
        $category = Category::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        // if not found then return 403
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 403);
        }

        // update category
        $category->update(array_filter([
            'name' => $request->name,
            'type' => $request->type
        ]));

        // return response
        return response()->json([
            'message' => 'Category updated!'
        ], 200);
    }

    // destroy method
    public function destroy(Request $request, $id)
    {
        // find category
        $category = Category::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        // if not found then return 403
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 403);
        }

        // delete category
        $category->delete();

        // return response
        return response()->json([
            'message' => 'Category deleted!'
        ], 200);
    }
}
