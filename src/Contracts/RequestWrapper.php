<?php

namespace TZK\Taiga\Contracts;

interface RequestWrapper
{
    public static $HTTP_VERBS = [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
    ];

    /**
     * Send a request to a specific endpoint.
     *
     * @param string $url
     * @param string $method
     * @param array  $data
     *
     * @throws TZK\Taiga\Exceptions\RequestException if an error occured (bad status code or error during transmission)
     *
     * @return mixed the json response decoded as an array or object
     */
    public function send($url, $method, $data = []);

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return TZK\Taiga\Contracts\RequestWrapper
     */
    public function setHeader($name, $value);

    /**
     * @param bool $bool
     *
     * @return TZK\Taiga\Contracts\RequestWrapper
     */
    public function enableSSL($bool = true);

    /**
     * @param string $agent
     *
     * @return TZK\Taiga\Contracts\RequestWrapper
     */
    public function setUserAgent($agent);

    /**
     * @return string
     */
    public function getErrorMessage();
}
