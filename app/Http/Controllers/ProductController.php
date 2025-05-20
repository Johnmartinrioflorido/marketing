<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index() {
        $products = auth()->user()->products;
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        return view('vendor.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->user_id = auth()->id(); // Ensure this is assigned
    
        // Save first to get an ID (if needed for image naming, optional)
        $product->save();
    
        // Handle image upload using Laravel's storage system
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->picture = $imagePath;  // Store relative path in DB
        }
    
        $product->save();
    
        return redirect()->route('vendor.products')->with('success', 'Product added successfully.');
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->picture = $path;  // Store the relative path in DB
        }
    
        $product->save();
    
        return redirect()->route('vendor.products')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Admin can delete any product
        if (auth()->user()->role === 'admin') {
            $product->delete();
            return redirect()->route('admin.products.manage')->with('success', 'Product deleted successfully.');
        }

        // Vendor can only delete their own products
        if (auth()->user()->role === 'vendor' && $product->user_id === auth()->id()) {
            $product->delete();
            return redirect()->route('vendor.products')->with('success', 'Your product has been deleted.');
        }

        // Unauthorized action
        return abort(403, 'Unauthorized action.');
    }
}
