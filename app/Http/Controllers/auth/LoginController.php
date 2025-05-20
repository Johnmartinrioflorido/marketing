<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
        
    }

  public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        } elseif ($user->role === 'customer') {
            return redirect()->route('shop.index');
        } elseif ($user->role === 'delivery') {
            return redirect()->route('delivery.dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors(['role' => 'Unauthorized role.']);
        }
    }

    return redirect()->route('login')->withErrors(['email' => 'Invalid credentials.']);
}


protected function authenticated(Request $request, $user)
{
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'vendor') {
        return redirect()->route('vendor.dashboard');
    } elseif ($user->role === 'delivery') {
        return redirect()->route('delivery.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
}
    
    public function redirectTo()
{
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => '/admin/dashboard',
        'vendor' => '/vendor/dashboard',
        'customer' => '/customer/dashboard',
        'delivery' => '/delivery/dashboard',
        default => '/',
    };
}
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
    
