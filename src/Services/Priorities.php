<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Priorities extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'priorities');
    }

    public function getList($params = [])
    {
        return $this->get(null, $params);
    }

    public function getById($id)
    {
        return $this->get($id);
    }
}
