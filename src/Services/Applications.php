<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Applications extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'applications');
    }

    public function getById($id)
    {
        return $this->get($id);
    }

    public function getByToken($id)
    {
        return $this->get(sprintf('%s/%s', $id, 'token'));
    }
}
