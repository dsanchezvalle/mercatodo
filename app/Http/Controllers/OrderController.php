<?php

namespace App\Http\Controllers;

use App\Address;
use App\Book;
use App\Http\Requests\CheckoutRequest;
use App\Order;
use App\Services\PlacetoPayServiceInterface;
use App\Services\RedirectRequest;
use App\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of Orders.
     *
     * @return Response
     */
    public function index(): Response
    {
        $userCart = Order::where('user_id', Auth::user()->id)->where('status', 'open')->first();

        return response()->view('shoppingcart.cart', compact('userCart'));
    }

    /**
     * @param Request $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $userCart = Auth::user()->orders()->firstOrCreate(['status' => 'open']);

        if ($userCart->books()->get()->contains($book)) {
            $userCart->books->find($book)->pivot->quantity +=  (int) $request->input('items');
            $userCart->books->find($book)->pivot->save();
        } else {
            $quantity = (int) $request->input('items');
            $userCart->books()->attach($book, ['quantity' => $quantity, 'unit_price' => $book->price]);
        }
        $userCart->total_amount = $userCart->getSubtotal();
        $userCart->save();

        return redirect()->route("bookshelf")->with('message', 'Book added to Cart! :)');
    }

    /**
     * @param Book $book
     * @return RedirectResponse
     */
    public function remove(Book $book): RedirectResponse
    {
        $userCart = Auth::user()->orders()->where('status', 'open')->first();
        $userCart->books()->detach($book->id);
        $userCart->total_amount = $userCart->getSubtotal();
        $userCart->save();

        if ($userCart->books()->get()->isEmpty()) {
            $userCart->delete();
        }

        return redirect()->route("cart.index");
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function checkout(Request $request): Response
    {
        $userOrder = Transaction::where('reference', $request->reference)->first()->order ?? Auth::user()->activeOrder();
        $books = $userOrder->books;
        return response()->view('shoppingcart.checkout', compact('userOrder', 'books'));
    }

    /**
     * @return Response
     */
    public function list()
    {
        $orders = Auth::user()->orders;
        return response()->view('order.index', compact('orders'));
    }

    /**
     * @param PlacetoPayServiceInterface $placetoPay
     * @param CheckoutRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function payment(PlacetoPayServiceInterface $placetoPay, CheckoutRequest $request)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('status', 'open')->first();
        $order->update(['address_id' => Address::create(array_replace($request->all(), ['user_id' => Auth::user()->id]))->id]);

        $request = new RedirectRequest($order, $request);

        $response = $placetoPay->payment($request->toArray());

        if ($response->isSuccessful()) {
            $order->update(['status' => 'closed']);

            Transaction::create(
                [
                'reference' => $request->getReference(),
                'order_id' => $order->id,
                'amount' => $order->getSubtotal(), //Check total or subtotal
                'request_id' => $response->requestId(),
                'status' => 'PENDING',
                'process_url' => $response->processUrl(),
                ]
            );

            return redirect($response->processUrl());
        }

        return redirect(route('bookshelf'))
            ->with('message', 'Unfortunately, your transaction could not be processed. Please try again later.');
    }

    /**
     * @param Request $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function edit(Request $request, Book $book): RedirectResponse
    {
        $userOrder = Auth::user()->orders()->where('status', 'open')->first();
        $userOrder->books->find($book)->pivot->quantity =  (int) $request->input('items');
        $userOrder->books->find($book)->pivot->save();

        $userOrder->total_amount = $userOrder->getSubtotal();
        $userOrder->save();

        return redirect()->route("cart.index")->with('message', 'Your order has been updated! :)');
    }
}
