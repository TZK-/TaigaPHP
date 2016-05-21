<?php

namespace Taiga\Service;


use Taiga\Service;

class IssueStatuses extends Service
{

    /**
     * Projects Endpoint constructor.
     * @param Api $root
     */
    public function __construct($root)
    {
        parent::__construct($root, 'issue-statuses');
    }

    /**
     * @param array $data
     *
     * @return \stdClass[]
     */
    public function getList(array $param = [])
    {
        return $this->get(null, $param);
    }

    public function create(array $data) {
        return $this->post(null, [], $data);
    }
    
    public function getById($id)
    {
        return $this->get($id);
    }

    public function edit($id, array $data) {
        return $this->put($id, [], $data);
    }

    public function editPartially($id, array $data) {
        return $this->patch($id, [], $data);
    }

    public function remove($id) {
        return $this->delete($id);
    }
}
