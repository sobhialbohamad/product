<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return[
        'id'=>$this->id,
        'name'=>$this->name,
      	'image_url'=>$this->image_url,
        'category'=>$this->category,
        'phone'=>$this->phone,
        'quantity'=>$this->quantity,
        'quantity_type'=>$this->quantity_type,
        'price'=>$this->price,
        'priceAfterdiscount'=>$this->priceAfterdiscount,
        'view_number'=>$this->view_number,

        // 'expiry_date'=>$this->expiry_date,
        // 'user_id'=>$this->user_id,
        // 'product_id'=>$this->	product_id,
        'product_active'=>$this->product_active,
      ];
    }
}
