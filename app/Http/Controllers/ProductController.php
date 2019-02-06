<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

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

    public function show($id) {
        return view('products.product_details');
    }

    // Start of admin only methods
    public function create() {
        return view('admin_panel.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'base_price' => 'required|integer',
            'description' => 'required',
            'special_price' => 'nullable|integer',
            'image' => 'required'
        ]);
        Product::create([
            'name' => request('name'),
            'base_price' => request('base_price'),
            'description' => request('description'),
            'special_price' => request('special_price'),
            'image' => request('image')
        ]);
        return redirect('/admin_panel')->with('success', 'Product Added');
    }
}
