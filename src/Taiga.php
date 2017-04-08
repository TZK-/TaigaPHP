<?php

namespace TZK\Taiga;

use Curl\Curl;
use TZK\Taiga\Exceptions\TaigaException;

class Taiga extends RestClient
{
    private $services = [];

    public function __construct($baseUrl, $token, $language = 'en')
    {
        parent::__construct($baseUrl, $token, $language);
        $this->curl->setHeader('Authorization', 'Bearer '.$token);
        $this->curl->setHeader('Accept-Language', $language);

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
