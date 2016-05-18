<?php

namespace Taiga\Service;


use Taiga\Service;

class UsersService extends Service
{

    /**
     * Users Endpoint constructor.
     * @param Api $root
     */
    public function __construct($root)
    {
        parent::__construct($root, 'users');
    }

    /**
     * @return \stdClass
     */
    public function getMe()
    {
        return $this->get('me');
    }

    public function getList(array $param = []) {
        return $this->get(null, $param);
    }
}

