<?php

namespace Taiga\Services;


use Taiga\RestClient;
use Taiga\Service;

class Resolvers extends Service {

    public function __construct(RestClient $root) {
        parent::__construct($root, 'resolvers');
    }

}