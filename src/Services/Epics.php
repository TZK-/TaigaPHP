<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class Epics extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'epics');
    }

    public function getList(array $param = [])
    {
        return $this->get(null, $param);
    }

    public function getById($id)
    {
        return $this->get($id);
    }

    public function getByRef($param)
    {
        return $this->get('by_ref', $param);
    }

    public function create($data)
    {
        return $this->post(null, [], $data);
    }

    public function relate($epicId, $userStoryId)
    {
        return $this->post(sprintf('%s/%s', $epicId, 'related_userstories'), [], [
            'epic' => $epicId,
            'user_story' => $userStoryId,
        ]);
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

    public function upvote($id)
    {
        return $this->post(sprintf('%s/%s', $id, 'upvote'));
    }

    public function downvote($id)
    {
        return $this->post(sprintf('%s/%s', $id, 'downvote'));
    }

    public function getVoters($id)
    {
        return $this->get(sprintf('%s/%s', $id, 'voters'));
    }

    public function watch($id)
    {
        return $this->post(sprintf('%s/%s', $id, 'watch'));
    }

    public function unwatch($id)
    {
        return $this->post(sprintf('%s/%s', $id, 'unwatch'));
    }

    public function getWatchers($id)
    {
        return $this->get(sprintf('%s/%s', $id, 'watchers'));
    }

    public function getAttachments($param)
    {
        return $this->get('attachments', $param);
    }

    public function createAttachment($data)
    {
        return $this->post('attachments', $data);
    }

    public function getAttachment($id)
    {
        return $this->get(sprintf('%s/%s', 'attachments', $id));
    }

    public function editAttachment($id, $data)
    {
        return $this->put($id, [], $data);
    }

    public function editAttachmentPartially($id, $data)
    {
        return $this->patch($id, [], $data);
    }

    public function deleteAttachment($id)
    {
        return $this->delete('attachments', $id);
    }
}
