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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Book $book
     * @return void
     */
    public function update(Request $request, Book $book)
    {
        $userCart = Auth::user()->orders()->firstOrCreate(['status' => 'open']);

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

    public function remove(Book $book)
    {
        Auth::user()->orders()->where('status', 'open')->first()->books()->detach($book->id);
        return redirect()->route("cart.index");
    }
}
