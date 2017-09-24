<?php

use TZK\Taiga\Header;
use TZK\Taiga\HeaderManager;

describe('HeaderManager', function () {
    given('manager', function () {
        return new HeaderManager();
    });

    given('shortcuts', function () {
        return [
            'language' => [
                'header' => 'Accept-Language',
            ],
            'authToken' => [
                'header' => 'Authorization',
                'prefix' => 'Bearer ',
            ],
        ];
    });

    beforeEach(function () {
        allow($this->manager)
            ->toReceive('getHeaderShortcuts')
            ->andReturn($this->shortcuts);
    });

    it('loads the right header shortcuts', function () {
        expect($this->manager->getHeaderShortcuts())->toBe($this->shortcuts);
    });

    it('asserts header has a shortcut', function () {
        expect($this->manager->isShortcut('language'))->toBe(true);
        expect($this->manager->isShortcut('shortcut_that_does_not_exist'))->toBe(false);
    });

    it('asserts shortcuts are case insensitive', function () {
        expect($this->manager->isShortcut('language'))->toBe(true);
        expect($this->manager->isShortcut('LANGUAGE'))->toBe(true);
    });

    it('asserts header has a prefix returns ', function () {
        $noPrefix = '';

        expect($this->manager->getPrefix('authToken'))->toBe('Bearer ');
        expect($this->manager->getPrefix('language'))->toBe($noPrefix);
    });

    it('build the right header if has shortcut without prefix', function () {
        $name = 'Accept-Language';
        $value = 'something';

        $header = new Header($name, $value);

        expect($this->manager->build('language', $value))->toEqual($header);
    });

    it('build the right header if has shortcut with prefix', function () {
        $name = 'Authorization';
        $authToken = 'my-super-safe-auth-token';
        $value = 'Bearer '.$authToken;

        $header = new Header($name, $value);

        expect($this->manager->build('authToken', $value))->toEqual($header);
    });

    it('build the right header if it does not have shortcut', function () {
        $name = 'Name';
        $value = 'Value';

        $header = new Header($name, $value);

        expect($this->manager->build($name, $value))->toEqual($header);
    });
});
