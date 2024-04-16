<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\Productuser;
use App\Comment;
use App\Like;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Basecontroller as Basecontroller;
use App\Http\Resources\Product as ProductResourse ;
use Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Basecontroller
{
    public function index()
    {
        $product=Product::where('product_active',1)->get();
        $Calcexpirydate=Productuser::all();
        $RawsNumbeInProductUser=Productuser::count();

         for ($i=0; $i<$RawsNumbeInProductUser; $i++) {
        //   // code...$to->diffInDays($from)
      $to=Carbon::parse($Calcexpirydate[$i]->expiry_date);
       $from=Carbon::now();
      if ($from>=$to)
      {

    Product::where('id',$Calcexpirydate[$i]->product_id)
        ->update(['product_active' =>0]);
      }
      else{
      $calcdiff= $from->diffInDays($to) ;
      if($calcdiff<=7)
      {
    $oldprice= Product::where('id',$Calcexpirydate[$i]->product_id)->value('price');
            Product::where('id',$Calcexpirydate[$i]->product_id)
            ->update(['priceAfterdiscount' =>($oldprice-$oldprice*0.7)]);
      }
      elseif($calcdiff>7 && $calcdiff<=15)
      {
        $oldprice= Product::where('id',$Calcexpirydate[$i]->product_id)->value('price');
                Product::where('id',$Calcexpirydate[$i]->product_id)
                ->update(['priceAfterdiscount' =>($oldprice-$oldprice*0.5)]);
      }
      elseif($calcdiff>15 && $calcdiff<=30)
      {
        $oldprice= Product::where('id',$Calcexpirydate[$i]->product_id)->value('price');
                Product::where('id',$Calcexpirydate[$i]->product_id)
                ->update(['priceAfterdiscount' =>($oldprice-$oldprice*0.3)]);
      }

     }

    }
    $newproduct=Product::where('product_active',1)->get();
      return $this->sendresponse(ProductResourse::collection($newproduct),'product retrieved Successfully!' );

  }




    public function store(Request $request)
    {
  //  $input = $request->all();
    $validator=Validator::make($request->all(),[
    'name'=>'required',
   'image_url'=>'required',
    'category'=>'required',
    'phone'=>'required',
    'quantity'=>'required',
    'quantity_type'=>'required',
    'price'=>'required',
    'expiry_date'=>'required',
  ]);
  if ($validator->fails()) {
    return $this->sendError('please validate error',$validator->errors());
  }
 // $photo =$request->image_url;
 // $newphoto = time().$photo->getClientOrginalName();
 //    $photo->move('public/images/'.$newphoto);


 // لا بقا تعدل بربو
    $product=Product::create([
      'name'=>$request->name,
     'image_url'=>$request->image_url,
      'category'=>$request->category,
      'phone'=>$request->phone,
      'quantity'=>$request->quantity,
      'quantity_type'=>$request->quantity_type,
      'price'=>$request->price,
      'priceAfterdiscount'=>$request->price,
      'view_number'=>0,
      'product_active'=>true,
      //'expiry_date'=>$request->expiry_date,
]);
// لا بقا تعدل بربو
 $produtuser=Productuser::create([
  'user_id'=>Auth::user()->id,
  'product_id'=>$product->id,// هنا أخذ القيمة صحيحة
  'expiry_date'=>$request->expiry_date,//هذه القيمة صحيحة
]);


// $request->Productuser()->clients()->create([
//     'email' => $request->email,
//     'age' => $request->age
// $product=DB::table('products')->where('id', DB::raw("(select max(`id`) from products)"))->first();
// //$user=Auth::user();
//  $productuser=Productuser::create([
//
//  'user_id'=>1,
//   'product_id'=>$product->id,
//   'expiry_date'  =>$request->expiry_date,
//  ]);

// $request['product_id']=  $product->id;
// $request['user_id']=$user->id;
// $product_id = $request['product_id'];
 return $this->sendresponse(new ProductResourse($product),'product created successfully');
    }
    public function show($id)
    {
        $product =Product::find($id);
        if(is_null( $product))
        {
          return $this->sendError('product not found');
        }
        $comment=Comment::where('product_id',$id)->orderby('created_at',desc)->get();
 $incrementView= Product::where('id', $product->id)->value('view_number')+1;
// تتم زيادة عدد المشاهدات بمقدار واحد بعد قيام المستخدم بمشاهدة المنتج
Product::where('id', $product->id)
->update(['view_number' =>$incrementView]);
$Liksnumber=Like::where('product_id',$product->id)
->where('like',1)->count();
//DB::table('products')->increment('view_number');
//return $this->sendresponse(new ProductResourse($product) ,'product found successfully');
  return response()->json([$product,$comment,$Liksnumber]);
    }
    public function update(Request $request, $id)
  {
        $input = Product::find($id);
        $product=$request->all();
          $validator=Validator::make($product,[
          'name'=>'required',
          'image_url'=>'required',
          'category'=>'required',
          'phone'=>'required',
          'quantity'=>'required',
          'quantity_type'=>'required',
          'price'=>'required',
        ]);
  // if($request->has('image_url'))
  //   {
  //     $photo=$request->image_url;
  //     $newphoto=time().$photo->getClientOrginalName();
  //     $photo->move('public/images/',$newphoto);
  //     $product->photo='public/images/'.$newphoto;
  //
  //   }
  $input->name=$product['name'];
  $input->image_url=  $product['image_url'];
  $input->category=  $product['category'];
  $input->phone=  $product['phone'];
  $input->quantity=  $product['quantity'];
  $input->quantity_type= $product['quantity_type'];
  $input->price=  $product['price'];
  $input->product_active=true;
  $input->save();
  // $product=Product::find($id);
  //       $product->update($request->all());
      //  return $product;

  return $this->sendresponse(new ProductResourse($input) ,'product updated successfully');
    }


    public function destroy(Product $product)
    {
          $product->product_active= 0;
          $product->save();
            return $this->sendresponse(new ProductResourse($product) ,'product deleted successfully');

    }
    public function search($type,$Seachstring)
    {
      //0 search by name 1 search by category 2 search by expiry_date
If($type==0)
  return Product::where('name',$Seachstring)->get();
    elseif ($type==1)
     {
         return Product::where('category',$Seachstring)->get();
      // code...
    }
    elseif ($type==2) {
      $N= Productuser::where('expiry_date',$Seachstring)->count();
      $procuctsID=Productuser::where('expiry_date',$Seachstring)->get('product_id');
     return Product::whereIn('id',$procuctsID)->get();
}

      // code...
    }


}
