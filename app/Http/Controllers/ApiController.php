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
    	//$products = Product::select('id', 'name', 'sku', 'post_tax_price', 'consumer_price', 'image')->where('status', '!=', 'null')->get();
       //return $products;
        //$result = ['products' => Product::select('id', 'name', 'sku', 'post_tax_price', 'consumer_price', 'image')->where('status', '!=', 'null')->get()];
        $avg_ratings = [];
        $products = Product::select('id', 'name', 'sku', 'post_tax_price', 'consumer_price', 'image')->where('status', '!=', 'null')->get();
        foreach($products as $product) {
            $avg_ratings[$product->id] = round(Product::find($product->id)->reviews()->avg('rating'), 2, PHP_ROUND_HALF_UP);
            $product->average = round(Product::find($product->id)->reviews()->avg('rating'), 2, PHP_ROUND_HALF_UP);
        }
        return $products;
    }

    public function detailed($id) {
    	$result = ['product' => Product::find($id), 'reviews' => Product::find($id)->reviews, 'avg_rating' => round(Product::find($id)->reviews()->avg('rating'), 2, PHP_ROUND_HALF_UP), 'review_count' => Product::find($id)->reviews()->count('rating')];
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
