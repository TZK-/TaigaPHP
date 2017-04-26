<?php

namespace TZK\Taiga;

use Curl\Curl;
use TZK\Taiga\Exceptions\TaigaException;

class Taiga extends RestClient
{
    protected static $HEADER_MAP = [
        'language' => [
            'header' => 'Accept-Language'
        ],
        'authToken' => [
            'header' => 'Authorization', 
            'prefix' => 'Bearer '
        ]
    ];

    private $services = [];

    public function __construct($baseUrl, $token, array $options = [])
    {
        parent::__construct($baseUrl, $token);
        $this->curl->setHeader('Authorization', 'Bearer '.$token);

        foreach($options as $header => $value)
            $this->{'set'.ucfirst($header)}($value);

        foreach (glob(__DIR__.'/Services/*.php') as $service) {
            $basename = basename($service, '.php');
            $class = 'TZK\\Taiga\\Services\\'.$basename;

            if (class_exists($class)) {
                $instance = new $class($this);
                if ($instance instanceof Service) {
                    $this->services[lcfirst($basename)] = $instance;
                }
            }
        }
    }

    /**
     * Get the Taiga auth token.
     *
     * @param $baseUrl the taiga API base url
     * @param array $credentials the credentials used to generete the token
     *
     * @throws TaigaException
     *
     * @return string the auth token
     */
    public static function getAuthToken($baseUrl, array $credentials)
    {
        $curl = new Curl();
        $curl->post($baseUrl.'/auth', $credentials);
        if ($curl->error) {
            throw new TaigaException(static::getErrorMessage($curl));
        }

        return $curl->response->auth_token;
    }

    public function __call($name, $params = [])
    {
        // If we call a method used to set HTTP headers.
        if(strpos($name, 'set') !== false) {
            // Remove the 'set' word from the method name.
            $name = substr($name, strlen('set'));
            $header = $this->getHeaderName($name);

            if(!isset($params[0]) || (isset($params[0]) && !trim($params[0]))) {
                throw new TaigaException("The header '$header' cannot be set because there is no value given.");
            }

            $headerValue = trim($params[0]);

            $headerMap = $this->getHeaderMap();
            $name = strtolower($name);

            if(isset($headerMap[$name])) {
                $header = $headerMap[$name]['header'];

                $prefixValue = '';
                if(isset($headerMap[$name]['prefix']) 
                    && !is_null($headerMap[$name]['prefix'])) {
                    $prefixValue = $headerMap[$name]['prefix'];
                }

                $headerValue = $prefixValue.$headerValue;
            }

            $this->curl->setHeader($header, $headerValue);

            return $this;
        }

        return $this->getService($name);
    }

    /**
     * Convert a camelcased string to a valid HTTP Header name.
     * @see http://www.ietf.org/rfc/rfc2616.txt
     * 
     * @param string $name
     *
     * @return string
     */
    protected function getHeaderName($name) {
        // @see http://stackoverflow.com/questions/4519739/split-camelcase-word-into-words-with-php-preg-match-regular-expression/7729790#7729790
        $regex = "/(?<=[a-z])(?=[A-Z])| (?<=[A-Z])(?=[A-Z][a-z])/x";
        $headerParts = preg_split($regex, $name);

        // Format the array to get a well formed header name (split by dashes if needed).
        // We do not need to worry about the writing since HTTP header field names are case-insensitive according to RFC-2616
        return implode('-', $headerParts);
    }

    protected function getHeaderMap() {
        return array_change_key_case(static::$HEADER_MAP, CASE_LOWER);
    }

    private function getService($name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }
        throw new TaigaException("The service $name is not defined");
    }

    public function curl() {
        return $this->curl;
    }
}
