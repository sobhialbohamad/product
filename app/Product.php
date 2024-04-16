<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  public $timestamps = false;
  protected $fillable=[
    'name',	'image_url','category','phone','quantity','quantity_type','price','priceAfterdiscount','view_number','product_active'
];
public function comment(){
  return $this->hasMany('App\Comment');
}
public function user(){
  return $this->belongsToMany('App\User');
}
}
