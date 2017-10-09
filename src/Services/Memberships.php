<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Memberships extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'memberships');
    }

    public function create(array $data)
    {
        $this->post(null, [], $data);
    }
}
