<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productuser extends Model
{
//  public $timestamps = false;
  protected $table='productusers';
protected $fillable=['user_id',	'product_id','expiry_date'];
//
// public function product(){
// return $this->belongsTo('app\Product',	'product_id');
// }
// public function user(){
//   return $this->belongsTo('App\user',	'user_id');
// }
}
