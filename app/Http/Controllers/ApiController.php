<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Tax;
use App\Review;

class ApiController extends Controller
{

    // Returns products to the front-end
    public function index() {
        $avg_ratings = [];
        // Only return the ones enabled
        $products = Product::select('id', 'name', 'sku', 'post_tax_price', 'consumer_price', 'image')->where('status', '!=', 'null')->get();
        foreach($products as $product) {
            $avg_ratings[$product->id] = round(Product::find($product->id)->reviews()->avg('rating'), 2, PHP_ROUND_HALF_UP);
            $product->average = round(Product::find($product->id)->reviews()->avg('rating'), 2, PHP_ROUND_HALF_UP);
            $product->post_tax_price = round($product->post_tax_price, 2, PHP_ROUND_HALF_UP);
            $product->consumer_price = round($product->consumer_price, 2, PHP_ROUND_HALF_UP);
        }
        return $products;
    }

    // Returns more detailed information for the details page
    public function detailed($id) {
        $product = Product::find($id);
        $product->post_tax_price = round($product->post_tax_price, 2, PHP_ROUND_HALF_UP);
        $product->consumer_price = round($product->consumer_price, 2, PHP_ROUND_HALF_UP);
    	$result = ['product' => $product, 'reviews' => Product::find($id)->reviews, 'avg_rating' => round(Product::find($id)->reviews()->avg('rating'), 2, PHP_ROUND_HALF_UP), 'review_count' => Product::find($id)->reviews()->count('rating')];
    	return $result;
    }

    // Post for review + rating
    public function saveReview(Request $request) {
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
