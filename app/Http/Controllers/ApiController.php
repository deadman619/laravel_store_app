<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Tax;

class ApiController extends Controller
{
    public function index() {
    	// Only return the ones enabled
    	$products = Product::select('id', 'name', 'sku', 'post_tax_price', 'consumer_price', 'image')->where('status', '!=', 'null')->get();
       return $products;
    }

    public function detailed($id) {
    	return $product = Product::find($id);
    }
}
