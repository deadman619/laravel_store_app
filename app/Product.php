<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;
    protected $fillable = ['name', 'sku', 'status', 'base_price', 'special_price', 'image', 'description'];
}
