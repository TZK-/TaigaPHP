<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class IssueStatuses extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'issue-statuses');
    }

    public function getList(array $param = [])
    {
        return $this->get(null, $param);
    }

    public function create(array $data)
    {
        return $this->post(null, [], $data);
    }

    public function getById($id)
    {
        return $this->get($id);
    }

    public function edit($id, array $data)
    {
        return $this->put($id, [], $data);
    }

    public function editPartially($id, array $data)
    {
        return $this->patch($id, [], $data);
    }

    public function remove($id)
    {
        return $this->delete($id);
    }
}
