<?php

namespace Taiga;

abstract class Service {

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var Taiga
     */
    private $root;

    /**
     * Service constructor.
     *
     * @param RestClient $root the API root object
     * @param $prefix
     */
    public function __construct($root, $prefix) {
        $this->root = $root;
        $this->prefix = $prefix;
    }

    protected function get($url, array $params = []) {
        $url = $url ? '/' . $url : '';
        return $this->root->request('GET', sprintf("%s%s?%s", $this->prefix, $url, http_build_query($params)));
    }

    protected function post($url, array $params = [], array $data = []) {
        $url = $url ? '/' . $url : '';
        return $this->root->request('POST', sprintf("%s%s?%s", $this->prefix, $url, http_build_query($params)), $data);
    }

    protected function put($url, array $params = [], array $data = []) {
        $url = $url ? '/' . $url : '';
        return $this->root->request('PUT', sprintf("%s%s?%s", $this->prefix, $url, http_build_query($params)), $data);
    }

    protected function patch($url, array $params = [], array $data = []) {
        $url = $url ? '/' . $url : '';
        return $this->root->request('PATCH', sprintf("%s%s?%s", $this->prefix, $url, http_build_query($params)), $data);
    }

    protected function delete($url, array $params = []) {
        $url = $url ? '/' . $url : '';
        return $this->root->request('DELETE', sprintf("%s%s?%s", $this->prefix, $url, http_build_query($params)));
    }

}