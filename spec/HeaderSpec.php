<?php

use TZK\Taiga\Header;

describe('Header', function () {
    it('creates header with sanitized name', function () {
        $tests = [
            'accept-language' => 'accept-language',
            'Accept-Language' => 'Accept-Language',
            'AcceptLanguage' => 'Accept-Language',
            'acceptLanguage' => 'accept-Language',
            'acceptlanguage' => 'acceptlanguage',
        ];

        foreach ($tests as $expect => $toBe) {
            $header = new Header($expect, 'value');
            expect($header->getName())->toBe($toBe);
        }
    });
});
