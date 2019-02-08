<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    public $timestamps = false;
    protected $fillable = ['enabled', 'tax_rate', 'global_discount'];
}
