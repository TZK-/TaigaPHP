<?php

namespace TZK\Taiga;

use Curl\Curl;
use TZK\Taiga\Exceptions\TaigaException;

class Taiga extends RestClient
{

    /**
     * @var array
     */
    private $services = [];


    public function __construct($baseUrl, $token = null, $language = 'en')
    {
        parent::__construct($baseUrl);
        $this->setAuthToken($token);
        $this->setLanguage($language);

        foreach (glob(__DIR__.'/Services/*.php') as $service) {
            $basename = basename($service, '.php');
            $class    = 'TZK\\Taiga\\Services\\'.$basename;

            if (class_exists($class)) {
                $instance = new $class($this);
                if ($instance instanceof Service) {
                    $this->services[lcfirst($basename)] = $instance;
                }
            }
        }
    }


    /**
     * Set authorization token.
     *
     * @param null|string $token
     *
     * @return $this
     */
    protected function setAuthToken($token = null)
    {
        if ( ! is_null($token)) {
            $this->curl->setHeader('Authorization', 'Bearer '.$token);
        }

        return $this;
    }


    /**
     * Set language header.
     *
     * @param null|string $language
     *
     * @return $this
     */
    protected function setLanguage($language = null)
    {
        if ( ! is_null($language)) {
            $this->curl->setHeader('Accept-Language', $language);
        }

        return $this;
    }


    /**
     * Get the Taiga auth token.
     *
     * @param       $baseUrl     the taiga API base url
     * @param array $credentials the credentials used to generate the token
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
        if ($name === 'setAuthToken') {
            return $this->setAuthToken(! empty($params) ? $params[0] : null);
        } elseif ($name === 'setLanguage') {
            return $this->setLanguage(! empty($params) ? $params[0] : null);
        }

        return $this->getService($name);
    }


    private function getService($name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }
        throw new TaigaException("The service $name is not defined");
    }
}
