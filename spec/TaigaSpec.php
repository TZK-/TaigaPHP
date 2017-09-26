<?php

use TZK\Taiga\Requests\NullRequest;
use TZK\Taiga\Services\Users;
use TZK\Taiga\Taiga;

describe('RestClient', function () {
    given('url', function () {
        return 'localhost';
    });

    given('client', function () {
        return new Taiga($this->request, $this->url);
    });

    given('request', function () {
        return new NullRequest();
    });

    it('initializes the request', function () {
        $request = new NullRequest();

        expect($request)
            ->toReceive('enableSSL')
            ->once();

        expect($request)
            ->toReceive('setUserAgent')
            ->once();

        expect($request)
            ->toReceive('setHeader')
            ->with('Content-Type', 'application/json')
            ->once();

        $client = new Taiga($request, $this->url);
    });

    it('asks the request to pass header', function () {
        expect($this->request)->toReceive('setHeader')
            ->with('Authorization', 'token')
            ->once();

        $this->client->setHeader('Authorization', 'token');
    });

    it('aks the request to pass list of headers', function () {
        $headers = [
            'Header1' => 'value1',
            'Header2' => 'value2',
            'Header3' => 'value3',
        ];

        expect($this->client)->toReceive('setHeader')
            ->times(count($headers));

        $this->client->setHeaders($headers);
    });

    it('asserts method may be a dynamic header setter', function () {
        expect($this->client->isDynamicSetter('setHeader'))->not->toBe(true);
        expect($this->client->isDynamicSetter('setAuthorization'))->toBe(true);
    });

    it('calls setHeader if uses dynamic method which is not a service or member method', function () {
        $header = 'MySuperHeader';
        $method = 'set'.$header;
        $value = 'mySuperValue';

        // We force the fact that we do not want to call a member method
        allow('method_exists')->toBeCalled()->andReturn(false);
        expect('method_exists')->toBeCalled()
            ->with($this->client, $method)
            ->times(2)
            ->ordered;

        expect($this->client)->toReceive('setHeader')
            ->with($header, $value)
            ->once();

        $this->client->$method($value);
    });

    it('tests if a method is a dynamic header setter', function () {
        $methods = [
            'setAuthorization' => true,
            'authorization' => false,
            'setHeaders' => false,
        ];

        foreach ($methods as $method => $toBe) {
            expect($this->client->isDynamicSetter($method))->toBe($toBe);
        }
    });

    it('sends the request with the right hostname and parameters', function () {
        $verb = 'GET';
        $endpoint = 'users/me';
        $data = [];

        expect($this->request)
            ->toReceive('send')
            ->with($this->url.'/'.$endpoint, $verb, $data)
            ->once();

        $this->client->request($verb, $endpoint, $data);
    });

    describe('Taiga', function () {
        it('returns the right service instance if uses dynamic method with service name', function () {
            $service = 'users';
            expect($this->client->$service())->toEqual(new Users($this->client));
        });
    });
});
