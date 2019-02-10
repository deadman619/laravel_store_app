<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Tax;
use App\Review;

class ApiController extends Controller
{
    public function index() {
    	// Only return the ones enabled
    	$products = Product::select('id', 'name', 'sku', 'post_tax_price', 'consumer_price', 'image')->where('status', '!=', 'null')->get();
       return $products;
    }

    public function detailed($id) {
    	$result = ['product' => Product::find($id), 'reviews' => Product::find($id)->reviews];
    	return $result;
    }

    public function saveReview(Request $request) {
    	//return $request;
    	$this->validate($request, [
            'name' => 'required|string',
            'review' => 'required',
            'rating' => 'required',
            'product_id' => 'required'
        ]);
        Review::create([
            'name' => request('name'),
            'review' => request('review'),
            'rating' => request('rating'),
            'product_id' => request('product_id')
        ]);
        return "Review Saved";
    }
}
