<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class IssueCustomAttributeValues extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'issues/custom-attributes-values');
    }

    public function getById($id)
    {
        return $this->get($id);
    }

    public function edit($id, $data)
    {
        return $this->put($id, [], $data);
    }

    public function editPartially($id, $data)
    {
        return $this->patch($id, [], $data);
    }
}
