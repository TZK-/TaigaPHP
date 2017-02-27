<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class ApplicationTokens extends Service
{
    public function __construct(RestClient $root)
    {
        parent::__construct($root, 'application-tokens');
    }

    public function getAll()
    {
        return $this->get(null);
    }

    public function getById($id)
    {
        return $this->get($id);
    }

    public function remove($id)
    {
        return $this->delete($id);
    }
}
