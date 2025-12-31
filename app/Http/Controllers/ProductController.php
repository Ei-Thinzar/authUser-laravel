<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products()->with('category')->get();
        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product->load('category')
        ], 201);
    }
}
