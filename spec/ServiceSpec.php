<?php

use TZK\Taiga\Requests\CurlRequest;
use TZK\Taiga\Service;
use TZK\Taiga\Services\Users;
use TZK\Taiga\Taiga;

describe('ServiceSpec', function () {
    given('url', function () {
        return 'localhost';
    });

    given('request', function () {
        return new CurlRequest();
    });

    given('client', function () {
        return new Taiga($this->request, $this->url);
    });

    given('service', function () {
        return $service = new Users($this->client);
    });

    it('uses the right parameters to send the request', function () {
        allow($this->client)
            ->toReceive('request')
            ->andReturn([]);

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
});
