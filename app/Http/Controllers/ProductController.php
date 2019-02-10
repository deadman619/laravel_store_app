<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Tax;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function show($id) {
        $product = Product::find($id);
        $tax = Tax::find(1);
        return view('admin_panel.products.product_details', compact('product', 'tax'));
    }

    public function admin() {
        $products = Product::all();
        $tax = Tax::find(1);
        return view('admin_panel.products.main', compact('products', 'tax'));
    }
    
    public function create() {
        return view('admin_panel.products.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required|integer',
            'base_price' => 'required|numeric',
            'description' => 'required',
            'individual_discount' => 'integer|nullable|digits_between:1,100',
            'image' => 'required|url'
        ]);
        Product::create([
            'name' => request('name'),
            'sku' => request('sku'),
            'base_price' => request('base_price'),
            'description' => request('description'),
            'individual_discount' => request('individual_discount'),
            'image' => request('image'),
            'status' =>request('status'),
        ]);
        $product = Product::orderby('id', 'desc')->first();
        $this->setIndividualTaxedPrice($product->id);
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
            'base_price' => 'required|numeric',
            'description' => 'required',
            'individual_discount' => 'integer|nullable|digits_between:1,100',
            'image' => 'required|url'
        ]);
        $product = Product::find($id);
        $product->update([
            'name' => request('name'),
            'sku' => request('sku'),
            'base_price' => request('base_price'),
            'description' => request('description'),
            'individual_discount' => request('individual_discount'),
            'image' => request('image'),
            'status' =>request('status')
        ]);
        $this->setIndividualTaxedPrice($product->id);
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

    public function setIndividualTaxedPrice($id) {
        $product = Product::find($id);
        $tax = Tax::find(1);
        if($tax->enabled) {
            $product->post_tax_price = $product->base_price + ($product->base_price * ($tax->tax_rate / 100));
        } else {
            $product->post_tax_price = $product->base_price;
        }
        if ($product->individual_discount) {
            $product->consumer_price = $product->post_tax_price - ($product->post_tax_price * ($product->individual_discount / 100));
        } else if ($tax->global_discount) {
            $product->consumer_price = $product->post_tax_price - ($product->post_tax_price * ($tax->global_discount / 100));
        } else {
            $product->consumer_price = $product->post_tax_price;
        }
        $product->post_tax_price = round($product->post_tax_price, 2, PHP_ROUND_HALF_UP);
        $product->consumer_price = round($product->consumer_price, 2, PHP_ROUND_HALF_UP);
        $product->update([
            'post_tax_price' => $product->post_tax_price,
            'consumer_price' => $product->consumer_price
        ]);
    }
}
