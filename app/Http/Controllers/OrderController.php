<?php

namespace App\Http\Controllers;

use App\Book;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $userCart = Order::where ('user_id', Auth::user()->id)->where('status', 'open')->first();

       return response()->view('shoppingcart.cart', compact('userCart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function show(Order $shoppingCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Book $book
     * @return void
     */
    public function update(Request $request, Book $book)
    {
        $userCart = Order::where ('user_id', Auth::user()->id)->where('status', 'open')->first();

        if ((int)$request->input('items')==0)
        {
            $userCart->books()->detach($book->id);
            return redirect()->route("cart.index");
        }
        if($userCart->books()->get()->contains($book))
        {
            $userCart->books->find($book)->pivot->quantity +=  (int)$request->input('items');
            $userCart->books->find($book)->pivot->save();
        }
        else
        {
            $quantity = $request->input('items');
            $userCart->books()->attach($book, ['quantity' => $quantity, 'unit_price' => $book->price]);
        }

        return redirect()->route("bookshelf")->with('message', 'Book added to Cart! :)');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $shoppingCart)
    {
        //
    }
}
