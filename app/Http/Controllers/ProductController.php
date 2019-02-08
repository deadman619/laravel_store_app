<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function index() {
        return view('app');
    }

    public function show($id) {
        $product = Product::find($id);
        if ($product->status) {
            return view('admin_panel.products.product_details', compact('product'));
        }
        return redirect('/products')->with('error', 'Product Unavailable');
    }

    public function admin() {
        $products = Product::all();
        return view('admin_panel.products.main', compact('products'));
    }
    
    public function create() {
        return view('admin_panel.products.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required|integer',
            'base_price' => 'required|integer',
            'description' => 'required',
            'special_price' => 'integer|nullable',
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
        return view('admin_panel.products.edit', compact('product'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required|integer',
            'base_price' => 'required|integer',
            'description' => 'required',
            'special_price' => 'integer|nullable',
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
        foreach($request->markedList as $markedItem) {
            $product = Product::find($markedItem);
            $product->delete();
        }
        return redirect('admin_panel')->with('success', 'Products Deleted');
    }
}
