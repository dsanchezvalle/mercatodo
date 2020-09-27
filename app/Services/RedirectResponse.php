<?php


namespace App\Services;


class RedirectResponse
{
    /**
     * @var mixed
     */
    private $status;
    /**
     * @var mixed
     */
    private $requestId;
    /**
     * @var mixed
     */
    private $processUrl;

    public function __construct(array $data)
    {
        $this->status = $data['status'];
        $this->requestId = $data['requestId'];
        $this->processUrl = $data['processUrl'];
    }

    public function processUrl()
    {
        return $this->processUrl;
    }

    public function requestId()
    {
        return $this->requestId;
    }

    public function isSuccessful()
    {
        return $this->status['status'] === 'OK';
    }

}
