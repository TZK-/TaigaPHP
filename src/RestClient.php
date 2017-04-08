<?php

namespace TZK\Taiga;

use Curl\Curl;
use TZK\Taiga\Exceptions\TaigaException;

abstract class RestClient
{
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1';

    /**
     * @var Curl
     */
    protected $curl;

    /**
     * @var the API base URL
     */
    private $baseUrl;

    /**
     * RestClient constructor.
     *
     * @param $baseUrl the API base URL
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->curl = new Curl();
        $this->curl->setHeader('Content-Type', 'application/json');
        $this->curl->setUserAgent(self::USER_AGENT);
        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, true);
    }

    /**
     * Send a HTTP request to a given URL with given data.
     *
     * @param string $method
     * @param string $url
     * @param array  $data
     *
     * @throws TaigaException
     *
     * @return array|StdClass
     */
    public function request($method, $url, array $data = [])
    {
        $this->curl->{strtolower($method)}($this->baseUrl.$url, $data);
        if ($this->curl->error) {
            throw new TaigaException(static::getErrorMessage($this->curl));
        }
        return $this->curl->response;
    }

    protected static function getErrorMessage(Curl $curl)
    {
        return sprintf('Error %s - %s: %s', 
            $curl->errorCode, 
            $curl->effectiveUrl, 
            $curl->errorMessage
        );
    }
}
