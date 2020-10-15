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
use Carbon\Carbon;

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
        $transaction = Transaction::where('reference', $reference)->first();
        $reference = $this->getReference();
        $data = (array) json_decode($transaction->payment_data);
        $payment = array_replace((array) $data['payment'], ['reference' => $reference]);
        $data = array_replace(
            $data,
            [
            'payment' => $payment,
            'expiration' => date('c', strtotime('+30 minutes')),
            'ipAddress' => $request->ip(),
            'userAgent' => $request->header('User-Agent'),
            'returnUrl' => 'http://mercatodo.test/transaction/' . $reference,
            'cancelUrl' => 'http://mercatodo.test/transaction/cancelled/' . $reference,
             ]
        );

        $response = $placetoPay->payment($data);
        if ($response->isSuccessful()) {
            $transaction->order->update(['status' => 'closed']);

            Transaction::create(
                [
                'reference' => $reference,
                'order_id' => $transaction->order->id,
                'amount' => $transaction->order->getSubtotal(), //Check total or subtotal
                'request_id' => $response->requestId(),
                'status' => 'PENDING',
                'process_url' => $response->processUrl(),
                'payment_data' => json_encode($data),
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

    /**
     * @return string
     */
    private function getReference(): string
    {
        $timeStamp = Carbon::now()->format('YmdHis');
        $userId = auth()->user()->id;

        return $userId . $timeStamp;
    }
}
