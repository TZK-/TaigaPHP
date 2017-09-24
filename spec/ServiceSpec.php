<?php

use TZK\Taiga\Requests\CurlRequest;
use TZK\Taiga\Service;
use TZK\Taiga\Services\Users;
use TZK\Taiga\Taiga;

describe('ServiceSpec', function () {
    given('client', function () {
        return new Taiga(new CurlRequest(), 'localhost');
    });

    given('service', function () {
        return $service = new Users($this->client);
    });

    it('sends request with valid verb', function () {
        $verbs = Service::$ALLOWED_HTTP_VERBS;
        foreach ($verbs as $verb) {
            $this->service->$verb();
        }
    });
});
