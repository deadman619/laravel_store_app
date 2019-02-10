<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	public $timestamps = false;
    protected $fillable = ['name', 'review', 'rating', 'product_id'];
    
    public function product() {
    	return $this->belongsTo('App\Product');
    }
}
