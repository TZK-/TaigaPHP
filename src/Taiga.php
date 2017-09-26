<?php

namespace TZK\Taiga;

use BadMethodCallException;
use TZK\Taiga\Contracts\RequestWrapper;

class Taiga extends RestClient
{
    private $serviceManager;

    public function __construct(RequestWrapper $request, $baseUrl, $token = null, array $headers = [])
    {
        parent::__construct($request, $baseUrl, $token);

        $this->serviceManager = new ServiceManager($this);

        $headers = array_merge($headers, ['authToken' => $token]);

        $this->setHeaders($headers);
    }

    public function __call($method, $params = [])
    {
        try {
            return parent::__call($method, $params);
        } catch (BadMethodCallException $e) {
            return $this->serviceManager->get($method);
        }
    }
}
