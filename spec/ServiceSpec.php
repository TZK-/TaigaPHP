<?php

use TZK\Taiga\Exceptions\RequestException;
use TZK\Taiga\Requests\NullRequest;
use TZK\Taiga\Service;
use TZK\Taiga\Services\Users;
use TZK\Taiga\Taiga;

describe('ServiceSpec', function () {
    given('url', function () {
        return 'localhost';
    });

    given('request', function () {
        return new NullRequest();
    });

    given('client', function () {
        return new Taiga($this->request, $this->url);
    });

    given('service', function () {
        return $service = new Users($this->client);
    });

    it('uses the right parameters to send the request', function () {
        $verb = 'GET';
        $endpoint = 'me';
        $params = [
            'param1' => 'value1',
            'param2' => 'value2',
        ];
        $data = [];

        expect($this->client)
            ->toReceive('request')
            ->with('GET', 'users/'.$endpoint.'?'.http_build_query($params), $data)
            ->once();

        $this->service->get($endpoint, $params, $data);
    });

    it('throws exception if sending request with not allowed verbs', function () {
        $allowedVerbs = Service::$ALLOWED_HTTP_VERBS;

        foreach ($allowedVerbs as $verb) {
            $closure = function () use ($verb) {
                return $this->service->$verb();
            };

            expect($closure)->not->toThrow(new RequestException());
        }

        $closure = function () {
            $notAllowedVerb = 'not_allowed';

            return $this->service->$notAllowedVerb();
        };

        expect($closure)->toThrow(new RequestException());
    });
});
