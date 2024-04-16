<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['comment','product_id','user_id'];
    public function product()
    {
      $this->belongsTo('App\Product','product_id');
    }
    public function user(){
      return $this->belongsTo('App\user',	'user_id');
    }
}
