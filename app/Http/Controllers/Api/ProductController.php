<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        // Get all products
        // $products = Product::all();

        $products = Product::take(1)->latest()->get();

        // Return the products as a JSON response
        return response()->json($products);
    }

    public function show($slug)
    {

        // Find the product by slug
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Get the product with its media
        $product->load('media');

        // Return the product as a JSON response
        return response()->json($product);
    }

}
