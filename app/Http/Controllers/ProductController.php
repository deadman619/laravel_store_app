<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct() {
    	// Only allows the methods in the exception list to users who are not logged in, otherwise redirects to login page
        $this->middleware('auth', ['except' => ['index', 'products', 'show']]);
    }

    public function index() {
        return view('products.index');
    }

    public function products() {
        return view('products.products');
    }
}
