<?php

namespace App\Http\Controllers;
use Validator;
use App\Like;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Basecontroller as Basecontroller;
use App\Http\Resources\Like as LikeResourse ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class LikeController extends Basecontroller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
      $product=Product::find($id);
      $validator=Validator::make($request->all(),[
      'like'=>'required',
    ]);
    if ($validator->fails()) {
      return $this->sendError('please! write your comment',$validator->errors());
    }
    $findlike=Like::where('user_id','=', Auth::user()->id )// to find if the user has added a previous like
                    ->where('product_id','=',  $product->id)->get();

//هنا يتم فحص هل تم اعجاب سابق و إذا لم يجده يقوم بانشاء حقل في جدول الاعجابات
if(($findlike)->isEmpty())
{
$addlike=Like::create([
    'like'=>1,
      'product_id'=>$product->id,
      'user_id'=> Auth::user()->id,


              ]);
  return $this->sendresponse(new LikeResourse ($addlike) ,'liked successfully');

}
else{
// update the value the user weather liked the product or  not

  //

  $value=Like::where('user_id',  Auth::user()->id)
            ->where('product_id',  $product->id)->value('like');

          if  ($value==1)

            {
                 Like::where('user_id',  Auth::user()->id)
                       ->where('product_id',  $product->id)
                       ->update(['like' =>0]);
            }
            elseif  ($value==0)
                {
                     Like::where('user_id',  Auth::user()->id)
                           ->where('product_id',  $product->id)
                           ->update(['like' =>1]);
                }
//



    }
  }

    /**
     * Display the specified resource.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //
    }
}
