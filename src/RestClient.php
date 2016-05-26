<?php

namespace Taiga;

use Curl\Curl;
use Taiga\Exceptions\TaigaException;

abstract class RestClient {

    const USER_AGENT = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1";

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
     * @param $token the public API token
     */
    public function __construct($baseUrl, $token) {
        $this->baseUrl = $baseUrl;
        $this->curl = new Curl();
        $this->curl->setHeader('Content-Type', 'application/json');
        $this->curl->setUserAgent(self::USER_AGENT);
        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, true);
    }

    /**
     * Send a HTTP request to a given URL with given data
     *
     * @param string $method the request method: POST - GET - PUT - PATCH - DELETE
     * @param string $url the url used to send the request
     * @param array $data the data to send with the request
     *
     * @return array|\StdClass
     * @throws \Exception
     */
    public function request($method, $url, array $data = []) {
        $this->curl->{strtolower($method)}($this->baseUrl . $url, $data);
        if ($this->curl->error)
            throw new TaigaException(self::getErrorMessage($this->curl));

        return $this->curl->response;
    }

    /**
     * Generate a string in case of request errors
     *
     * @param Curl $curl the curl request
     *
     * @return string
     */
    protected static function getErrorMessage(Curl $curl) {
        return 'Error ' . $curl->errorCode . ' on page' . $curl->effectiveUrl . ' : ' . $curl->errorMessage;
    }

    /**
     * @return Curl
     */
    public function getCurl() {
        return $this->curl;
    }

}
