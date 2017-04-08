<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Severities extends Service
{
    
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'severities');
    }

    public function getList($param = [])
    {
        return $this->get(null, $param);
    }

    public function getById($id)
    {
        return $this->get($id);
    }
}
