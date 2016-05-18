<?php

namespace Taiga\Service;


use Taiga\Service;

class IssueTypesService extends Service
{

    public function __construct($root)
    {
        parent::__construct($root, 'issue-types');
    }

    public function getList(array $param)
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

    public function remove($id) {
        return $this->delete($id);
    }

    public function vote($id) {
        return $this->post(sprintf('%s/upvote', $id));
    }

    public function bulkUpdateOrder(array $data) {
        return $this->post('bulk_update_order', [], $data);
    }
}

