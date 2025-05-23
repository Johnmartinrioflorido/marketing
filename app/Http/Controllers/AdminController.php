<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Vendor;     // ✅ Needed for Vendor::count() and Vendor::latest()
use App\Models\Delivery;   // ✅ Needed for Delivery::with()

class AdminController extends Controller
{
public function dashboard()
{
    // Get the list of customers
    $customerList = User::where('role', 'customer')->latest()->take(5)->get(); // Or use the appropriate query for customers

    // Get the count of customers
    $customers = $customerList->count();

    // Other variables (vendors, products, orders)
    $vendors = Vendor::count();
    $products = Product::count();
    $orders = Order::count();

    // Recent orders, vendors, and products
    $recentOrders = Order::latest()->take(5)->with('user')->get();
    $vendorList = Vendor::latest()->take(5)->get();
    $productList = Product::latest()->take(5)->get();

    // Pass all variables to the view
    return view('admin.dashboard', compact(
        'vendors',
        'customers',
        'products',
        'orders',
        'vendorList',
        'productList',
        'customerList',  // Make sure this variable is passed
        'recentOrders'
    ));
}

    public function viewVendors()
    {
        $vendors = User::where('role', 'vendor')->latest()->paginate(10);
        return view('admin.vendors', compact('vendors'));
    }


    public function viewCusOrders()
    {
    // Fetch orders with their associated user (customer)
    $orders = Order::with('user')->latest()->get();

    // Optionally, fetch all customers if needed in the view
    $customers = User::where('role', 'customer')->get();

    return view('admin.manage-orders', compact('orders', 'customers'));
    }
    public function manageProducts()
    {
        $products = Product::with('vendor')->latest()->get();
        $vendors = User::where('role', 'vendor')->get();
        return view('admin.manage-products', compact('products', 'vendors'));
    }
   
public function viewCustomers()
{
    $customerList = \App\Models\User::where('role', 'customer')->paginate(10);
    $customers = $customerList->total(); // total count

    return view('admin.customers', compact('customerList', 'customers'));
}

    public function viewOrders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function viewDeliveries()
    {
        $deliveries = Delivery::with(['order', 'user'])->latest()->paginate(10);
        return view('admin.deliveries', compact('deliveries'));
    }
    public function index()
{
    // Ensure this retrieves the collection of products for the authenticated vendor
    $products = auth()->user()->products()->get(); // get() returns a collection

    // Check if the products are indeed a collection or an array
    return view('vendor.products.index', compact('products'));
}
}
