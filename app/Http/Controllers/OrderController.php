<?php

namespace App\Http\Controllers;

use App\Book;
use App\Order;
use App\Services\PlacetoPayServiceInterface;
use App\Transaction;
use Carbon\Carbon;
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
     * @return \Illuminate\Http\RedirectResponse
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
        $userCart->total_amount = $userCart->getSubtotal();
        $userCart->save();
        return redirect()->route("bookshelf")->with('message', 'Book added to Cart! :)');
    }

    public function remove(Book $book)
    {
        $userCart = Auth::user()->orders()->where('status', 'open')->first();
        $userCart->books()->detach($book->id);
        $userCart->total_amount = $userCart->getSubtotal();
        $userCart->save();
        if($userCart->books()->get()->isEmpty()){
            $userCart->delete();
        }

        return redirect()->route("cart.index");
    }

    public function checkout()
    {
        return view('shoppingcart.checkout');
    }

    public function payment(PlacetoPayServiceInterface $placetoPay)
    {
        $order = Order::where ('user_id', Auth::user()->id)->where('status', 'open')->first();
        $reference = $this->getReference();
        $request = [
            'locale' => 'es_CO',
            'buyer' => [
                'name' => Auth::user()->name,
                'surname' => Auth::user()->surname,
                'email' => 'd@d.com',
                'address' => [
                    'street' => '703 Dicki Island Apt. 609',
                    'city' => 'North Randallstad',
                    'state' => 'Antioquia',
                    'postalCode' => '46292',
                    'country' => 'US',
                    'phone' => '363-547-1441 x383',
                ],
            ],
            'payment' => [
                'reference' => $reference,
                'description' => 'PlacetoPay payment',
                'amount' => [
                    'taxes' => [
                        [
                            'kind' => 'ice',
                            'amount' => 56.4,
                            'base' => 470,
                        ],
                        [
                            'kind' => 'valueAddedTax',
                            'amount' => 89.3,
                            'base' => 470,
                        ],
                    ],
                    'details' => [
                        [
                            'kind' => 'shipping',
                            'amount' => 47,
                        ],
                        [
                            'kind' => 'tip',
                            'amount' => 47,
                        ],
                        [
                            'kind' => 'subtotal',
                            'amount' => 940,
                        ],
                    ],
                    'currency' => 'COP',
                    'total' => $order->getSubtotal(),
                ],
                'items' => [
                    [
                        'sku' => 26443,
                        'name' => 'Qui voluptatem excepturi.',
                        'category' => 'physical',
                        'qty' => 1,
                        'price' => 940,
                        'tax' => 89.3,
                    ],
                ],
                'shipping' => [
                    'name' => Auth::user()->name,
                    'surname' => Auth::user()->surname,
                    'email' => 'd@d.com',
                    'documentType' => 'CC',
                    'document' => '1848839248',
                    'mobile' => '3006108300',
                    'address' => [
                        'street' => '703 Dicki Island Apt. 609',
                        'city' => 'North Randallstad',
                        'state' => 'Antioquia',
                        'postalCode' => '46292',
                        'country' => 'US',
                        'phone' => '363-547-1441 x383',
                    ],
                ],
                'allowPartial' => false,
            ],
            'expiration' => date('c', strtotime('+1 hour')),
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36',
            'returnUrl' => 'http://mercatodo.test/response/' . $reference,
            'cancelUrl' => 'http://mercatodo.test/response/' . $reference,
            'skipResult' => false,
            'noBuyerFill' => false,
            'captureAddress' => false,
            'paymentMethod' => null,
        ];

        $response = $placetoPay->payment($request);

        if($response->isSuccessful()){

            Transaction::create(
            [
              'reference' => $reference,
              'order_id' => $order->id,
              'amount' => $order->getSubtotal(), //Check total or subtotal
              'request_id' => $response->requestId(),
              'status' => 'PENDING',
              'process_url' => $response->processUrl(),
            ]
            );

            return redirect($response->processUrl());
        }
    }

    public function getReference()
    {
        $timeStamp = Carbon::now()->format('YmdHi');
        $userId = auth()->user()->id;

        return $userId . $timeStamp;
    }

}
