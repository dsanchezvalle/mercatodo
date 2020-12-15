<?php

namespace App\Jobs;

use App\Services\PlacetoPayServiceInterface;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckTransactionStatusJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param  PlacetoPayServiceInterface $placetoPay
     * @return void
     */
    public function handle(PlacetoPayServiceInterface $placetoPay)
    {
        $transactions = Transaction::all()->where('status', '==', 'PENDING');

        foreach ($transactions as $transaction) {
            if (($transaction->created_at)->addDay()->greaterThan(Carbon::now())) {
                $response = $placetoPay->sessionQuery($transaction->request_id);
                $transaction->update(['status' => $response ['status']['status']]);
            } else {
                $transaction->update(['status' => 'EXPIRED']);
            }
        }
    }
}
