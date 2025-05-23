<?php

// File: app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the vendor's products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch only products belonging to the logged-in vendor
        $products = auth()->user()->products;
        return view('vendor.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('vendor.products.create');
    }

    /**
     * Store a newly created product in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Create a new product and assign values
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->user_id = auth()->id(); // Ensure the product belongs to the logged-in user
        
        // Save the product before handling the image upload (optional step)
        $product->save();
        
        // Handle the image upload if an image is provided
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('products', 'public');
            $product->picture = $imagePath;  // Store the image path in the database
            $product->save();
        }

        return redirect()->route('vendor.products')->with('success', 'Product added successfully.');
    }

    /**
     * Update the specified product in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Update the product with new values
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        
        // Handle image upload if a new image is provided
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('products', 'public');
            $product->picture = $path;  // Store the relative path of the image
        }

        $product->save(); // Save the product

        return redirect()->route('vendor.products')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from the database.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Allow deletion only for products belonging to the logged-in user
        if ($product->user_id === auth()->id()) {
            $product->delete();
            return redirect()->route('vendor.products')->with('success', 'Your product has been deleted.');
        }

        return abort(403, 'Unauthorized action.');
    }
    // OrderController.php
public function placeOrder(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($productId);
    
        $quantity = $request->input('quantity');
        $total = $product->price * $quantity;

        $product->stock -= $quantity;

        $product->save();

    //   print($product->stock -= $quantity);
    
        Order::create([
        'product_id' => $productId,
        'user_id' => auth()->id(), // use 'user_id' to match the DB column
        'total' => $total,
        'status' => 'pending',
        'delivery_status' => 'pending',
        ]);
    
        return redirect()->route('orders.view')->with('success', 'Order placed successfully.');
    }
public function viewOrders()
{
    $orders = Order::with('product')
        ->where('user_id', auth()->id()) // or user_id, depending on your field
        ->where(function ($query) {
            $query->where('delivery_status', '!=', 'delivered')
                  ->orWhere('updated_at', '>=', Carbon::now()->subDays(2));
        })
        ->latest()
        ->get();

    return view('orders.index', compact('orders'));
}
}