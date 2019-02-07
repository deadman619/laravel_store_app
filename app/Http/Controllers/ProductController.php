<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function __construct() {
        // Checks if the user is an administrator, redirects back to the homepage with an error message if not
        $this->middleware('admin', ['except' => ['index', 'products', 'show']]);
    }

    public function index() {
        return view('products.index');
    }

    public function products() {
        // Only returns the products where status is set to true
        $products = Product::where('status', '=', 1)->paginate(12);
        return view('products.products', compact('products'));
    }

    public function show($id) {
        $product = Product::find($id);
        if ($product->status) {
            return view('products.product_details', compact('product'));
        }
        return redirect('/products')->with('error', 'Product Unavailable');
    }

    // Start of admin only methods

    public function admin() {
        $products = Product::all();
        return view('admin_panel.main', compact('products'));
    }
    
    public function create() {
        return view('admin_panel.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required|integer',
            'base_price' => 'required|integer',
            'description' => 'required',
            'special_price' => 'required|integer',
            'image' => 'required'
        ]);
        Product::create([
            'name' => request('name'),
            'sku' => request('sku'),
            'base_price' => request('base_price'),
            'description' => request('description'),
            'special_price' => request('special_price'),
            'image' => request('image'),
            'status' =>request('status')
        ]);
        return redirect('/admin_panel')->with('success', 'Product Added');
    }

    public function edit($id) {
        $product = Product::find($id);
        return view('admin_panel.edit', compact('product'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required|integer',
            'base_price' => 'required|integer',
            'description' => 'required',
            'special_price' => 'required|integer',
            'image' => 'required'
        ]);
        $product = Product::find($id);
        $product->update([
            'name' => request('name'),
            'sku' => request('sku'),
            'base_price' => request('base_price'),
            'description' => request('description'),
            'special_price' => request('special_price'),
            'image' => request('image'),
            'status' =>request('status')
        ]);
        return redirect('/admin_panel')->with('success', 'Product Updated');
    }

    public function destroy($id) {
        $product = Product::find($id);
        $product->delete();
        return redirect('admin_panel')->with('success', 'Product Deleted');
    }

    public function massDestroy(Request $request) {
        //return $request;
        foreach($request->markedList as $markedItem) {
            $product = Product::find($markedItem);
            $product->delete();
        }
        return redirect('admin_panel')->with('success', 'Products Deleted');
    }
}
