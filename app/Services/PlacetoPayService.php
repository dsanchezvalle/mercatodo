<?php


namespace App\Services;


use GuzzleHttp\Client;

class PlacetoPayService implements PlacetoPayServiceInterface
{
    public function payment(array $paymentData)
    {
        $client = new Client();
        $response = $client->post(env('P2P_ENDPOINT_BASE') . '/api/session', [
            'json' => array_replace_recursive([
                'auth' => $this->auth()
            ], $paymentData)
        ]);
        return new RedirectResponse(json_decode($response->getBody()->getContents(), true));
    }

    private function auth()
    {
        $seed = date('c');
        $nonce = mt_rand();

        return [
            'login' => env('P2P_LOGIN'),
            'tranKey' => base64_encode(sha1($nonce . $seed . env('P2P_SECRET_KEY'), true)),
            'nonce' => base64_encode($nonce),
            'seed' => $seed,
        ];
    }
}
