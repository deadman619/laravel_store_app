<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        // Checks if the user is an administrator, redirects back to the homepage with an error message if not
        if(auth()->user()->is_admin) {
            $products = Product::all();
            return view('admin_panel.main', compact('products'));
        }
        return redirect('/')->with('error', 'Unauthorized user');
    }
}
