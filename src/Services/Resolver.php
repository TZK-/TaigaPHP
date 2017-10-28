<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Resolver extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'resolver');
    }
}
