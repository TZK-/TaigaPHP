<?php

namespace Taiga;

class Taiga extends RestClient {

    public $issues;
    public $issueStatuses;
    public $issueTypes;
    public $priorities;
    public $projects;
    public $severities;
    public $users;

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
        
        $services = ['issues', 'issueStatuses', 'issueTypes', 'priorities', 'projects', 'severities', 'users'];
        foreach ($services as $service) {
            $class = 'Taiga\\Service\\' . ucwords($service) . 'Service';
            $this->{$service} = new $class($this);
        }
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

}
