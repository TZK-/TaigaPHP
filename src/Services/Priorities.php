<?php

namespace TZK\Taiga\Services;


use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Priorities extends Service
{

    /**
     * Projects Endpoint constructor.
     * @param Api $root
     */
    public function __construct(RestClient $root)
    {
        parent::__construct($root, 'priorities');
    }

    /**
     * @params array $params
     *  - project: project id
     *
     * @return \stdClass[]
     */
    public function getList($params = [])
    {
        return $this->get(null, $params);
    }

    /**
     * @param $id
     * @return array
     */
    public function getById($id)
    {
        return $this->get($id);
    }

}
