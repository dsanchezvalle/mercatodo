<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PlacetoPayService implements PlacetoPayServiceInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * PlacetoPayService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $paymentData
     * @return RedirectResponse
     * @throws GuzzleException
     */
    public function payment(array $paymentData): RedirectResponse
    {
        try {
            $response = $this->client->post(
                env('P2P_ENDPOINT_BASE') . '/api/session',
                [
                'json' => array_replace_recursive(
                    [
                    'auth' => $this->auth()
                    ],
                    $paymentData
                )
                ]
            );
            return new RedirectResponse(json_decode($response->getBody()->getContents(), true));
        } catch (\Exception $exception) {
            return new  RedirectResponse(
                [
                'status' => [
                    'status' => 'FAILED',
                    'reason' => '',
                    'message' => '',
                    'date' => now(),
                ]
                ]
            );
        }
    }

    /**
     * @param int $requestId
     * @return mixed
     * @throws GuzzleException
     */
    public function sessionQuery(int $requestId)
    {
        try {
            $response = $this->client->post(
                env('P2P_ENDPOINT_BASE') . '/api/session/' . $requestId,
                [
                'json' => ['auth' => $this->auth()]
                ]
            );
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            return json_decode($exception->getMessage());
        }
    }

    /**
     * @return array
     */
    private function auth(): array
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
