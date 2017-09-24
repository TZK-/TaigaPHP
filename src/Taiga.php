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

        $this->setAuthorization($token)
            ->setHeaders($headers);
    }

    public function __call($name, $params = [])
    {
        try {
            return parent::__call($name, $params);
        } catch (BadMethodCallException $e) {
            return $this->serviceManager->get($name);
        }
    }
}
