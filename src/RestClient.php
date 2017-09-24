<?php

namespace TZK\Taiga;

use BadMethodCallException;
use TZK\Taiga\Contracts\RequestWrapper;

abstract class RestClient
{
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1';

    /**
     * @var TZK\Taiga\Contracts\RequestWrapper
     */
    protected $request;

    /**
     * @var TZK\Taiga\HeaderManager
     */
    protected $headerManager;

    /**
     * @var string the API base URL
     */
    protected $baseUrl;

    /**
     * RestClient constructor.
     *
     * @param TZK\Taiga\Contracts\RequestWrapper
     * @param $baseUrl the API base URL
     */
    public function __construct(RequestWrapper $request, $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->headerManager = new HeaderManager();
        $this->request = $request
            ->enableSSL()
            ->setUserAgent(self::USER_AGENT);

        $this->setHeader('Content-Type', 'application/json');
    }

    /**
     * Send a HTTP request to a given URL with given data.
     *
     * @param string $method
     * @param string $url
     * @param array  $data
     *
     * @return mixed
     */
    public function request($method, $url, array $data = [])
    {
        return $this->request->send($this->baseUrl.$url, $method, $data);
    }

    public function __call($method, $params = [])
    {
        // If we call a method used to set HTTP headers.
        if ($this->isSetter($method)) {
            // Remove the 'set' word from the method name.
            $name = substr($method, strlen('set'));
            $header = Header::sanitize($name);
            $value = null;

            if (isset($params[0])) {
                $value = trim($params[0]);
            }

            return $this->setHeader($header, $value);
        }

        throw new BadMethodCallException("The method '$name' does not exist.");
    }

    protected function isSetter($method)
    {
        return strpos($method, 'set') !== false;
    }

    public function setHeaders(array $headers = [])
    {
        foreach ($headers as $name => $value) {
            $this->setHeader($name, $value);
        }

        return $this;
    }

    protected function setHeader($name, $value)
    {
        $header = $this->headerManager->build($name, $value);

        $this->request->setHeader($header->getName(), $header->getValue());

        return $this;
    }
}
