<?php

namespace TZK\Taiga;

use TZK\Taiga\Exceptions\RequestException;

abstract class Service
{
    protected static $ALLOWED_HTTP_METHODS = ['GET', 'POST', 'PUT', 'PATCH'];

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var Taiga
     */
    private $taiga;

    /**
     * Services constructor.
     *
     * @param RestClient $taiga
     * @param $prefix
     */
    public function __construct(RestClient $taiga, $prefix)
    {
        $this->taiga = $taiga;
        $this->prefix = $prefix;
    }

    public function __call($method, $arguments) 
    {
        $method = strtoupper($method);

        if(!in_array($method, static::$ALLOWED_HTTP_METHODS)) {
            throw new RequestException(sprintf("The HTTP method '%s' is not allowed. The only allowed methods are %s.", 
                $name,
                implode(', ', static::$ALLOWED_HTTP_METHODS)
            ));
        }

        $url = isset($arguments[0]) ? '/'.$arguments[0] : '';
        $params = isset($arguments[1]) ? $arguments[1] : [];
        $data = isset($arguments[2]) ? $arguments[2] : [];

        return $this->taiga->request(
            $method, 
            sprintf('%s%s?%s', $this->prefix, $url, http_build_query($params), $data)
        );
    }
}
