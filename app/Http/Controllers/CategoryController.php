<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Get all categories successful',
            'data' => [
                'categories' => $category
            ]
        ], 200);
    }
}
