<?php

namespace TZK\Taiga\Requests;

use Curl\Curl;
use TZK\Taiga\Contracts\RequestWrapper;
use TZK\Taiga\Exceptions\RequestException;

class CurlRequest implements RequestWrapper
{
    protected $curl;

    public function __construct()
    {
        $this->curl = new Curl();
    }

    public function send($url, $method, $data = [])
    {
        $this->curl->{strtolower($method)}($url, $data);
        if ($this->curl->error) {
            throw new RequestException($this->getErrorMessage());
        }

        return $this->curl->response;
    }

    public function setHeader($name, $value)
    {
        $this->curl->setHeader($name, $value);
    }

    public function setUserAgent($agent)
    {
        $this->curl->setUserAgent($agent);
    }

    public function enableSSL($bool = true)
    {
        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, $bool);
    }

    public function getErrorMessage()
    {
        return sprintf(
            'Error %s - %s: %s',
            $this->curl->errorCode,
            $this->curl->effectiveUrl,
            $this->curl->errorMessage
        );
    }
}
