<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class IssueCustomAttributes extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'issue-custom-attributes');
    }

    public function getList(array $param = [])
    {
        return $this->get(null, $param);
    }

    public function getById($id)
    {
        return $this->get($id);
    }

    public function create($data)
    {
        return $this->post(null, [], $data);
    }

    public function edit($id, $data)
    {
        return $this->put($id, [], $data);
    }

    public function editPartially($id, $data)
    {
        return $this->patch($id, [], $data);
    }

    public function remove($id)
    {
        return $this->delete($id);
    }
}
