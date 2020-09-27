<?php

namespace App\Http\Controllers;

use App\Book;
use App\Order;
use App\Services\PlacetoPayServiceInterface;
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

    public function checkout()
    {
        return view('shoppingcart.checkout');
    }

    public function payment(PlacetoPayServiceInterface $placetoPay)
    {
        $request = json_decode('{
    "locale": "es_CO",
    "buyer": {
        "name": "Isabella",
        "surname": "Caro",
        "email": "isabellacaro@javeriana.edu.co",
        "address": {
            "street": "Carrera 6 # 45 - 09 Apto 1016 Edificio Portal de la javeriana II",
            "city": "Bogota",
            "phone": "3206515736",
            "country": "CO"
        },
        "mobile": null
    },
    "payment": {
        "reference": "300038996",
        "description": "Pago en PlacetoPay",
        "amount": {
            "taxes": [
                {
                    "kind": "valueAddedTax",
                    "amount": "42635.0000",
                    "base": 224397
                }
            ],
            "details": [
                {
                    "kind": "subtotal",
                    "amount": "224397.0000"
                },
                {
                    "kind": "discount",
                    "amount": 0
                },
                {
                    "kind": "shipping",
                    "amount": "0.0000"
                }
            ],
            "currency": "COP",
            "total": "267032.0000"
        },
        "shipping": {
            "name": "Isabella",
            "surname": "Caro",
            "email": "isabellacaro@javeriana.edu.co",
            "address": {
                "street": "Carrera 6 # 45 - 09 Apto 1016 Edificio Portal de la javeriana II",
                "city": "Bogota",
                "phone": "3206515736",
                "country": "CO"
            },
            "mobile": null
        }
    },
    "returnUrl": "https:\/\/www.ciudaddemascotas.com\/Perros\/placetopay\/processing\/response\/?reference=300038996",
    "expiration": "' . date('c', strtotime('+2 days')) . '",
    "ipAddress": "190.249.138.19",
    "userAgent": "Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/55.0.2883.87 Safari\/537.36"
}', true);
        $response = $placetoPay->payment($request);
        if($response->isSuccessful()){
            return redirect($response->processUrl());
        }
    }

}
