<?php

namespace Taiga\Services;


use Taiga\Services;

class Severities extends Service
{

    /**
     * Projects Endpoint constructor.
     * @param Api $root
     */
    public function __construct($root)
    {
        parent::__construct($root, 'severities');
    }

    /**
     * @params array $params
     *  - project: project id
     *
     * @return \stdClass[]
     */
    public function getList($param = [])
    {
        return $this->get(null, $param);
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

