<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'enabled', 'tax_rate', 'global_discount'];
}
