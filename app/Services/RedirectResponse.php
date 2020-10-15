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

    /**
     * RedirectResponse constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->status = $data['status'];
        $this->requestId = $data['requestId'] ?? null;
        $this->processUrl = $data['processUrl'] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function processUrl()
    {
        return $this->processUrl;
    }

    /**
     * @return mixed|null
     */
    public function requestId()
    {
        return $this->requestId;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->status['status'] === 'OK';
    }
}
