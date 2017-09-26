<?php

namespace TZK\Taiga\Requests;

use TZK\Taiga\Contracts\RequestWrapper;

class NullRequest implements RequestWrapper
{
    public function send($url, $method, $data = [])
    {
        return [];
    }

    public function setHeader($name, $value)
    {
        return $this;
    }

    public function setUserAgent($agent)
    {
        return $this;
    }

    public function enableSSL($bool = true)
    {
        return $this;
    }

    public function getErrorMessage()
    {
        return '';
    }
}
