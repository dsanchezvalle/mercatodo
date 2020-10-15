<?php

namespace App\Http\Controllers;

use Illuminate\{
    Contracts\Foundation\Application,
    Contracts\View\Factory,
    Http\RedirectResponse,
    Http\Request,
    Routing\Redirector,
    View\View
};
use App\{
    Services\PlacetoPayServiceInterface,
    Transaction
};

class TransactionController extends Controller
{
    /**
     * @param int $reference
     * @return Application|Factory|View
     */
    public function cancel(int $reference)
    {
        Transaction::where('reference', $reference)->first()->update(['status' => 'REJECTED']);
        return view('transaction.cancel', ['reference' => $reference]);
    }

    /**
     * @param int $reference
     * @param PlacetoPayServiceInterface $placetoPay
     * @return RedirectResponse
     */
    public function status(int $reference, PlacetoPayServiceInterface $placetoPay): RedirectResponse
    {
        $transaction = Transaction::where('reference', $reference)->first();
        $response = $placetoPay->sessionQuery($transaction->request_id);
        $transaction->update(['status' => $response['status']['status']]);
        return redirect()->route("transaction.result", $reference);
    }

    /**
     * @param Request $request
     * @param $reference
     * @param PlacetoPayServiceInterface $placetoPay
     * @return Application|RedirectResponse|Redirector
     */
    public function retry(Request $request, $reference, PlacetoPayServiceInterface $placetoPay)
    {
        $order = Transaction::where('reference', $reference)->first()->order;

        $request = new RedirectRequest($order, $request);

        $response = $placetoPay->payment($request->toArray());
        if ($response->isSuccessful()) {
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
     * @param int $reference
     * @param PlacetoPayServiceInterface $placetoPay
     * @return Application|Factory|View
     */
    public function result(int $reference, PlacetoPayServiceInterface $placetoPay)
    {
        $transaction = Transaction::where('reference', $reference)->first();
        $response = $placetoPay->sessionQuery($transaction->request_id);
        $transaction->update(['status' => $response['status']['status']]);

        return view('transaction.result', ['reference' => $reference, 'status' => $transaction->status]);
    }
}
