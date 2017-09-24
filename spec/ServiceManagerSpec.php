<?php

use Kahlan\Plugin\Monkey;
use TZK\Taiga\Exceptions\TaigaException;
use TZK\Taiga\Requests\CurlRequest;
use TZK\Taiga\ServiceManager;
use TZK\Taiga\Services\Users;
use TZK\Taiga\Taiga;

describe('ServiceManager', function () {
    given('client', function () {
        return new Taiga(new CurlRequest(), 'localhost');
    });

    given('manager', function () {
        return new ServiceManager($this->client);
    });

    beforeEach(function () {
        // We do not autoload services
        Monkey::patch('glob', function () {
            return [];
        });
    });

    it('throws exception if tries to build service from somthing which is not a class', function () {
        $closure = function () {
            $class = 'aClassThatDoesNotExist';
            $this->manager->build($class);
        };

        expect($closure)->toThrow(new TaigaException());
    });

    it('throws exception if tries to build service from an non Service instance', function () {
        $closure = function () {
            $class = 'stdClass';
            $this->manager->build($class);
        };

        expect($closure)->toThrow(new TaigaException());
    });

    it('builds the right service', function () {
        $service = $this->manager->build(Users::class);
        expect($this->manager->isService($service))->toBe(true);
    });

    it('add service with the right name', function () {
        $service = new Users($this->client);
        $serviceName = 'users';

        $this->manager->add($service);
        expect($this->manager->get('users'))->toEqual($service);
    });

    it('throws exception if tries to get service that does not exist', function () {
        $closure = function () {
            $this->manager->get('service_that_does_not_exist');
        };

        expect($closure)->toThrow(new TaigaException());
    });
});
