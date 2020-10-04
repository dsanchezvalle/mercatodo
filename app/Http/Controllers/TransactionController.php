<?php

namespace App\Http\Controllers;

use App\Order;
use App\Services\PlacetoPayServiceInterface;
use App\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function cancel(int $reference, PlacetoPayServiceInterface $placetoPay)
    {
        Transaction::where('reference', $reference)->first()->update(['status' => 'REJECTED']);
        //$transaction = Transaction::where('reference', $reference)->first();
        //$response = $placetoPay->sessionQuery($transaction->request_id);
        //dd($response);
        //Trigger TRACKING PROCESS...
        return view('transaction.cancel', ['reference' => $reference]);
        //dd('Your payment was rejected. Want to try again?');
    }

    public function status(int $reference, PlacetoPayServiceInterface $placetoPay)
    {
        $transaction = Transaction::where('reference', $reference)->first();
        $response = $placetoPay->sessionQuery($transaction->request_id);

//        if($response ['status']['status'] == 'APPROVED'){
            $transactionStatus = $this->getPaymentStatus($response);  //Check REQUEST STATUS
            $transaction->update(['status' => $transactionStatus]);
            return redirect()->route("transaction.result", $reference);
  //      }
        //else{
            //$response->
        //}

    }

    public function result(int $reference)
    {
        return view('transaction.result', ['reference' => $reference]);
    }

    public function getPaymentStatus(array $response)
    {
        return  $response ['payment']['0']['status']['status'];
    }
}
