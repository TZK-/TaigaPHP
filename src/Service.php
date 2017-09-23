<?php

namespace TZK\Taiga;

use TZK\Taiga\Contracts\RequestWrapper;
use TZK\Taiga\Exceptions\RequestException;

abstract class Service
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var TZK\Taiga\RestClient
     */
    private $client;

    public function __construct(RestClient $client, $prefix)
    {
        $this->client = $client;
        $this->prefix = $prefix;
    }

    public function __call($method, $arguments)
    {
        $method = strtoupper($method);

        if (!in_array($method, RequestWrapper::$HTTP_VERBS)) {
            throw new RequestException(
                sprintf(
                    "The HTTP method '%s' is not allowed. The only allowed methods are %s.",
                    $method,
                    implode(', ', RequestWrapper::$HTTP_VERBS)
                )
            );
        }

        $url = isset($arguments[0]) ? '/'.$arguments[0] : '';
        $params = isset($arguments[1]) ? $arguments[1] : [];
        $data = isset($arguments[2]) ? $arguments[2] : [];

        return $this->client->request(
            $method,
            sprintf('%s%s?%s', $this->prefix, $url, http_build_query($params)),
            $data
        );
    }
}
