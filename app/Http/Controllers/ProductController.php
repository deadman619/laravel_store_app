<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Tax;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }
    
    // Show individual product in admin panel
    public function show($id) {
        $product = Product::find($id);
        $tax = Tax::find(1);
        return view('admin_panel.products.product_details', compact('product', 'tax'));
    }

    // Show main page of admin panel
    public function admin() {
        $products = Product::all();
        $tax = Tax::find(1);
        return view('admin_panel.products.main', compact('products', 'tax'));
    }
    
    // Show create page
    public function create() {
        return view('admin_panel.products.create');
    }

    // Save created product
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required|integer',
            'base_price' => 'required|numeric',
            'description' => 'required',
            'individual_discount' => 'integer|nullable|digits_between:1,100',
            'image' => 'required_without:upload_image|nullable|url',
            'upload_image' => 'required_without:image|image|max:4096'
        ]);

        // If both are filled, this prioritizes URL over upload
        // Adding timestamp to filename to avoid potential filename conflicts
        if(!$request->image && $request->hasFile('upload_image')) {
            $imageLocation = '/storage/images/_'.time().$request->file('upload_image')->getClientOriginalName();
            $path = $request->file('upload_image')->storeAs('public/images', '_'.time().$request->file('upload_image')->getClientOriginalName());
        } else {
            $imageLocation = request('image');
        }

        Product::create([
            'name' => request('name'),
            'sku' => request('sku'),
            'base_price' => request('base_price'),
            'description' => request('description'),
            'individual_discount' => request('individual_discount'),
            'image' => $imageLocation,
            'status' =>request('status'),
        ]);
        
        $product = Product::orderby('id', 'desc')->first();
        $this->setIndividualTaxedPrice($product->id);
        return redirect('/admin_panel')->with('success', 'Product Added');
    }

    // Show edit page
    public function edit($id) {
        $product = Product::find($id);
        return view('admin_panel.products.edit', compact('product'));
    }

    // Update edited product
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required|integer',
            'base_price' => 'required|numeric',
            'description' => 'required',
            'individual_discount' => 'integer|nullable|digits_between:1,100',
            'image' => 'nullable|url',
            'upload_image' => 'nullable|image|max:4096'
        ]);

        $product = Product::find($id);
        if(!$request->image && $request->hasFile('upload_image')) {
            $imageLocation = '/storage/images/_'.time().$request->file('upload_image')->getClientOriginalName();
            $path = $request->file('upload_image')->storeAs('public/images', '_'.time().$request->file('upload_image')->getClientOriginalName());
            $this->uploadedImageDelete($product);
        } else if($request->image) {
            $imageLocation = request('image');
            $this->uploadedImageDelete($product);
        } else {
            $imageLocation = $product->image;
        }

        $product->update([
            'name' => request('name'),
            'sku' => request('sku'),
            'base_price' => request('base_price'),
            'description' => request('description'),
            'individual_discount' => request('individual_discount'),
            'image' => $imageLocation,
            'status' =>request('status')
        ]);
        $this->setIndividualTaxedPrice($product->id);
        return redirect('/admin_panel')->with('success', 'Product Updated');
    }

    // Delete product
    public function destroy($id) {
        $product = Product::find($id);
        $this->uploadedImageDelete($product);
        $product->delete();
        return redirect('admin_panel')->with('success', 'Product Deleted');
    }

    // Delete selected products
    public function massDestroy(Request $request) {
        foreach($request->markedList as $markedItem) {
            $product = Product::find($markedItem);
            $this->uploadedImageDelete($product);
            $product->delete();
        }
        return redirect('admin_panel')->with('success', 'Products Deleted');
    }

    // If image is from upload, delete the image from storage
    public function uploadedImageDelete($product) {
        if(!filter_var($product->image, FILTER_VALIDATE_URL)) {
            Storage::delete(str_replace('storage', 'public', $product->image));
        }
    }

    // Calculate taxed price and discount right after a product is created or updated
    public function setIndividualTaxedPrice($id) {
        $product = Product::find($id);
        $tax = Tax::find(1);
        // If tax hasn't been set at all, both post tax and consumer prices are set to base price
        if($tax && $tax->enabled) {
            $product->post_tax_price = $product->base_price + ($product->base_price * ($tax->tax_rate / 100));
        } else {
            $product->post_tax_price = $product->base_price;
        }
        if ($product->individual_discount) {
            $product->consumer_price = $product->post_tax_price - ($product->post_tax_price * ($product->individual_discount / 100));
        } else if ($tax && $tax->global_discount) {
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
