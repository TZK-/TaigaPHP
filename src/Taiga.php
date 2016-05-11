<?php

namespace Taiga;

class Taiga extends RestClient {

    public $issues;

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

        $services = ['issues'];
        foreach ($services as $service) {
            $class = 'Taiga\\Service\\' . ucwords($service) . 'Service';
            $this->{$service} = new $class($this);
        }
    }

}
