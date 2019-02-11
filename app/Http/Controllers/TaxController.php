<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tax;
use App\Product;

class TaxController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    // Initially sends admin to create new tax, afterwards sends to tax update page
    public function index() {
    	if(!Tax::find(1)) {
        	return view('admin_panel.taxes.tax_create');
    	} else {
    		$tax = Tax::find(1);
    		return view('admin_panel.taxes.tax_configure', compact('tax'));
    	}
    }

    // Saves initial tax and global discount settings
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'tax_rate' => 'required|integer',
            'global_discount' => 'nullable|integer',
        ]);
        Tax::create([
            'name' => request('name'),
            'tax_rate' => request('tax_rate'),
            'global_discount' => request('global_discount'),
            'enabled' =>request('enable')
        ]);
        $this->setTaxedPrice();
        return redirect('/admin_panel')->with('success', 'Tax Settings Saved');
    }

    // Updates tax and global discount settings
    public function update(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'tax_rate' => 'required|integer',
            'global_discount' => 'nullable|integer',
        ]);
        $tax = Tax::find(1);
        $tax->update([
            'name' => request('name'),
            'tax_rate' => request('tax_rate'),
            'global_discount' => request('global_discount'),
            'enabled' =>request('enable')
        ]);
        $this->setTaxedPrice();
        return redirect('/admin_panel')->with('success', 'Tax Settings Saved');
    }

    // Called everytime taxes or discount is set or updated to recalculate prices for everything
    public function setTaxedPrice() {
        $products = Product::all();
        $tax = Tax::find(1);
        foreach($products as $product) {
            // Apply tax to base price
            if ($tax->enabled) {
                $product->post_tax_price = $product->base_price + ($product->base_price * ($tax->tax_rate / 100));
            } else {
                $product->post_tax_price = $product->base_price;
            }
            // If exists, apply individual discount or global discount
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
}
