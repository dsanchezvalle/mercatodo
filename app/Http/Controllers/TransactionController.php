<?php

namespace App\Http\Controllers;

use App\Services\PlacetoPayServiceInterface;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function cancel(int $reference, PlacetoPayServiceInterface $placetoPay)
    {
        Transaction::where('reference', $reference)->first()->update(['status' => 'REJECTED']);
        return view('transaction.cancel', ['reference' => $reference]);
    }

    public function status(int $reference, PlacetoPayServiceInterface $placetoPay)
    {
        $transaction = Transaction::where('reference', $reference)->first();
        $response = $placetoPay->sessionQuery($transaction->request_id);
        $transaction->update(['status' => $response['status']['status']]);
        return redirect()->route("transaction.result", $reference);
    }

    public function retry(Request $request, $reference, PlacetoPayServiceInterface $placetoPay)
    {
        $transaction = Transaction::where('reference', $reference)->first();
        $reference = $this->getReference();
        $data = (array) json_decode($transaction->payment_data);
        $payment = array_replace((array) $data['payment'], ['reference' => $reference]);
        $data = array_replace( $data, [
            'payment' => $payment,
            'expiration' => date('c', strtotime('+30 minutes')),
            'ipAddress' => $request->ip(),
            'userAgent' => $request->header('User-Agent'),
            'returnUrl' => 'http://mercatodo.test/transaction/' . $reference,
            'cancelUrl' => 'http://mercatodo.test/transaction/cancelled/' . $reference,
        ]);

        $response = $placetoPay->payment($data);
        if($response->isSuccessful()){
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

    public function result(int $reference)
    {
        return view('transaction.result', ['reference' => $reference]);
    }

    private function getReference()
    {
        $timeStamp = Carbon::now()->format('YmdHis');
        $userId = auth()->user()->id;

        return $userId . $timeStamp;
    }
}
