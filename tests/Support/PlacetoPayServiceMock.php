<?php


namespace Tests\Support;


use App\Services\PlacetoPayServiceInterface;
use App\Services\RedirectResponse;

class PlacetoPayServiceMock implements PlacetoPayServiceInterface
{

    /**
     * @var array
     */
    private $response;

    public function payment(array $paymentData): RedirectResponse
    {
        if ($this->response) {
            return new RedirectResponse($this->response);
        }

        return new RedirectResponse([
            'status' => [
                'status' => 'OK',
                'reason' => '',
                'message' => '',
                'date' => now(),
            ],
            'requestId' => 12345,
            'processUrl' => 'http://mock.service']);
    }

    public function sessionQuery(int $requestId)
    {
        if ($this->response) {
            return new RedirectResponse($this->response);
        }

        return array (
                'requestId' => 412760,
                'status' =>
                    array (
                        'status' => 'APPROVED',
                        'reason' => 'PC',
                        'message' => 'La petición se encuentra activa',
                        'date' => '2020-10-04T23:09:39-05:00',
                    ),
                'request' =>
                    array (
                        'locale' => 'es_CO',
                        'buyer' =>
                            array (
                                'document' => '1040035000',
                                'documentType' => 'CC',
                                'name' => 'Cole',
                                'surname' => 'Casper',
                                'email' => 'dnetix@yopmail.com',
                                'mobile' => '3006108300',
                            ),
                        'payment' =>
                            array (
                                'reference' => 'TEST_20201004_230816',
                                'description' => 'Ex voluptatibus quibusdam sed molestias.',
                                'amount' =>
                                    array (
                                        'currency' => 'COP',
                                        'total' => 126000,
                                    ),
                                'allowPartial' => false,
                                'subscribe' => false,
                            ),
                        'returnUrl' => 'https://dnetix.co/p2p/client',
                        'ipAddress' => '179.13.20.15',
                        'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36',
                        'expiration' => '2020-10-05T23:08:16-05:00',
                        'captureAddress' => false,
                        'skipResult' => false,
                        'noBuyerFill' => false,
                    ),
            );
    }

    public function setResponse(array $data)
    {
        $this->response = $data;
    }
}
