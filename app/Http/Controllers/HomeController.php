<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Redirect based on user role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.home');
        } else {
            // User biasa diarahkan ke user home route
            return redirect()->route('user.home');
        }
    }
}
