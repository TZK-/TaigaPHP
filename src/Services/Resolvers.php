<?php

namespace TZK\Taiga\Services;


use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Resolvers extends Service {

    public function __construct(RestClient $root) {
        parent::__construct($root, 'resolvers');
    }

}
