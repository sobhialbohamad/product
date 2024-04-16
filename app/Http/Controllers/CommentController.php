<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Basecontroller as Basecontroller;
use App\Http\Resources\Comment as CommentResourse ;
use Validator;
use Illuminate\Support\Facades\DB;

class CommentController extends Basecontroller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function store(Request $request,$id)
    {
      $product=Product::find($id);
      $validator=Validator::make($request->all(),[
      'comment'=>'required',
    ]);
    if ($validator->fails()) {
      return $this->sendError('please! write your comment',$validator->errors());
    }
    $comment=Comment::create([
        'comment'=>$request->comment,
        'user_id'=> Auth::user()->id,
        'product_id'=>$product->id,

  ]);
   return $this->sendresponse($comment,'Comment added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
