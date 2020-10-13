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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        foreach($transactions as $transaction){
            if(($transaction->created_at)->addDay()->greaterThan(Carbon::now())) {
                var_dump(($transaction->created_at)->addDay()->greaterThan(Carbon::now()));
                var_dump('Ahora: ' . Carbon::now() . ' Creada (+1): ' . ($transaction->created_at)->addDay());
                $response = $placetoPay->sessionQuery($transaction->request_id);
                $transaction->update(['status' => $response ['status']['status']]);
            }
            else{
                var_dump(($transaction->created_at)->addDay()->greaterThan(Carbon::now()));
                var_dump('Ahora: ' . Carbon::now() . ' Creada (+1): ' . ($transaction->created_at)->addDay());
                $transaction->update(['status' => 'EXPIRED']);
            }
        }
    }
}
