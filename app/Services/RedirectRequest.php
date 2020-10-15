<?php

namespace App\Services;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectRequest
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var Request
     */
    private $request;
    /**
     * @var string
     */
    private $reference;

    public function __construct(Order $order, Request $request)
    {
        $this->order = $order;
        $this->request = $request;
        $this->createReference();
    }

    public function toArray()
    {
        return [
            'locale' => 'en_US',
            'buyer' => [
                'name' => Auth::user()->name,
                'surname' => Auth::user()->surname,
                'email' => Auth::user()->email,
                'document' => Auth::user()->document_number,
                'address' => $this->order->address->toArray(),
            ],
            'payment' => [
                'reference' => $this->getReference(),
                'amount' => [
                    'currency' => 'COP',
                    'total' => $this->order->getSubtotal(),
                ],
                'shipping' => [
                    'name' => Auth::user()->name,
                    'surname' => Auth::user()->surname,
                    'email' => Auth::user()->email,
                    'documentType' => Auth::user()->document_type,
                    'document' => Auth::user()->document_number,
                    'mobile' => $this->order->address->mobile,
                    'address' => $this->order->address->toArray(),
                ],
                'allowPartial' => false,
            ],
            'expiration' => date('c', strtotime('+30 minutes')),
            'ipAddress' => $this->request->ip(),
            'userAgent' => $this->request->header('User-Agent'),
            'returnUrl' => 'http://mercatodo.test/transaction/' . $this->getReference(),
            'cancelUrl' => 'http://mercatodo.test/transaction/cancelled/' . $this->getReference(),
            'skipResult' => false,
            'noBuyerFill' => false,
        ];
    }

    private function createReference()
    {
        $timeStamp = Carbon::now()->format('YmdHis');
        $userId = auth()->user()->id;

        $this->reference = $userId . $timeStamp;
    }

    public function getReference()
    {
        return $this->reference;
    }
}
