<?php

namespace TZK\Taiga;

use TZK\Taiga\Exceptions\TaigaException;

class Taiga extends RestClient {

    private $services = [];

    /**
     * Taiga constructor.
     *
     * @param $baseUrl the API base URL
     * @param $token the public API token
     *
     * @throws Exception
     */
    public function __construct($baseUrl, $token) {
        parent::__construct($baseUrl, $token);
        $this->curl->setHeader('Authorization', 'Bearer ' . $token);

        foreach (glob(__DIR__ . '/Services/*.php') as $file) {
            $attr = lcfirst(basename($file, '.php'));
            $class = 'TZK\\Taiga\\Services\\' . basename($file, '.php');

            if(class_exists($class))
                $this->services[$attr] = new $class($this);
        }
    }

    /**
     * Get the Taiga auth token
     *
     * @param $baseUrl the taiga API base url
     * @param array $credentials the credentials used to generete the token
     *
     * @return string the auth token
     * @throws TaigaException
     */
    public static function getAuthToken($baseUrl, array $credentials) {
        $curl = new Curl();
        $curl->post($baseUrl . '/auth', $credentials);
        if ($curl->error)
            throw new TaigaException(self::getErrorMessage($curl));

        return $curl->response->auth_token;
    }

    public function __call($name, $params = []) {
        return $this->getService($name);
    }

    private function getService($name) {
        if(isset($this->services[$name])) return $this->services[$name];
        throw new TaigaException("The service $name is not defined");
    }

}
