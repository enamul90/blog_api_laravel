<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // 🔹 Get All Categories
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Category::latest()->get()
        ]);
    }

    // 🔹 Store Category
    public function store(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'description'  => 'required|string',
            'status'       => 'required|in:active,inactive'
        ]);

        $category = Category::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }


    // 🔹  Get category By id
    public function show(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    // 🔹 Get category by status
    public function getByStatus(Request $request)
    {
        $status = $request->query('status'); // ?status=active
    
        if (!in_array($status, ['active', 'inactive'])) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid status value'
            ], 400);
        }
    
        $categories = Category::where('status', $status)->get();
    
        if ($categories->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No category found with this status'
            ], 404);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Category list fetched successfully',
            'data' => $categories
        ], 200);
    }



    // 🔹 Update Category
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $request->validate([
            'categoryName' => 'required|string|max:255',
            'description'  => 'required|string',
            'status'       => 'required|in:active,inactive'
        ]);

        $category->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    // 🔹 Delete Category
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
