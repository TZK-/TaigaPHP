<?php

namespace Taiga;

use Curl\Curl;

abstract class RestClient {

    const USER_AGENT = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1";

    /**
     * @var Curl
     */
    private $curl;

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
        $this->curl->setHeader('Authorization', 'Bearer ' . $token);
        $this->curl->setUserAgent(self::USER_AGENT);
        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, true);
    }

    /**
     * Get the Taiga auth token
     *
     * @param $baseUrl the taiga API base url
     * @param array $credentials the credentials used to generete the token
     *
     * @return string the auth token
     * @throws \HttpRequestException if a request error occurred
     */
    public static function getAuthToken($baseUrl, array $credentials) {
        $curl = new Curl();
        $curl->post($baseUrl . '/auth', $credentials);
        if ($curl->error)
            throw new \HttpRequestException(self::getErrorMessage($curl));

        return $curl->response->auth_token;
    }

    /**
     * Generate a string in case of request errors
     *
     * @param Curl $curl the curl request
     *
     * @return string
     */
    private static function getErrorMessage(Curl $curl) {
        return 'Error ' . $curl->errorCode . ': ' . $curl->errorMessage;
    }

    /**
     * Send a HTTP request to a given URL with given data
     *
     * @param string $method the request method: POST - GET - PUT - PATCH - DELETE
     * @param string $url the url used to send the request
     * @param array $data the data to send with the request
     *
     * @return \StdClass
     * @throws \Exception
     */
    public function request($method, $url, array $data = []) {
        $this->curl->{strtolower($method)}($this->baseUrl . $url, $data);
        if ($this->curl->error)
            throw new \Exception(self::getErrorMessage($this->curl));
        return $this->curl->response;
    }

}
