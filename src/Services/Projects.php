<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Projects extends Service
{
    
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'projects');
    }

    public function getList(array $param = [])
    {
        return $this->get(null, $param);
    }

    public function getById($id)
    {
        return $this->get($id);
    }

    public function getBySlug($slug)
    {
        return $this->get('by_slug', ['slug' => $slug]);
    }

    public function getProjectModulesConfiguration($id)
    {
        return $this->get(sprintf('%s/modules', $id));
    }

    public function getProjectStats($id)
    {
        return $this->get(sprintf('%s/stats', $id));
    }

    public function getProjectIssueStats($id)
    {
        return $this->get(sprintf('%s/issues_stats', $id));
    }

    public function getProjectIssueFiltersData($id)
    {
        return $this->get(sprintf('%s/issue_filters_data', $id));
    }

    public function getProjectTagsColors($id)
    {
        return $this->get(sprintf('%s/tags_colors', $id));
    }

    public function getFans($id)
    {
        return $this->get(sprintf('%s/fans', $id));
    }

    public function getWatchers($id)
    {
        return $this->get(sprintf('%s/watchers', $id));
    }

    public function create(array $data)
    {
        return $this->post(null, [], $data);
    }

    public function updateProjectsOrderForLoggedInUser($id, array $data)
    {
        return $this->post(sprintf('%s/bulk_update_order', $id), [], $data);
    }

    public function like($id, array $data)
    {
        return $this->post(sprintf('%s/like', $id), [], $data);
    }

    public function unlike($id, array $data)
    {
        return $this->post(sprintf('%s/unlike', $id), [], $data);
    }

    public function watch($id, array $data)
    {
        return $this->post(sprintf('%s/watch', $id), [], $data);
    }

    public function unwatch($id, array $data)
    {
        return $this->post(sprintf('%s/unwatch', $id), [], $data);
    }

    public function createTemplate($id, array $data)
    {
        return $this->post(sprintf('%s/create_template', $id), [], $data);
    }

    public function leave($id, array $data)
    {
        return $this->post(sprintf('%s/leave', $id), [], $data);
    }

    public function changeLogo($id, array $data)
    {
        return $this->post(sprintf('%s/change_logo', $id), [], $data);
    }

    public function removeLogo($id, array $data)
    {
        return $this->post(sprintf('%s/remove_logo', $id), [], $data);
    }

    public function modifyPartiallyAProject($id, $data)
    {
        return $this->patch(sprintf('%s', $id), [], $data);
    }

    public function modifyPartiallyAProjectModulesConfiguration($id, array $data)
    {
        return $this->patch(sprintf('%s/modules', $id), [], $data);
    }

    public function edit($id, array $data)
    {
        return $this->put($id, [], $data);
    }
}
