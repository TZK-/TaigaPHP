<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Users extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'users');
    }

    public function getMe()
    {
        return $this->get('me');
    }

    public function getList(array $param = [])
    {
        return $this->get(null, $param);
    }
}
