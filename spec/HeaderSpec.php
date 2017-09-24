<?php

use TZK\Taiga\Header;

describe('Header', function () {
    it('sanitizes header name to a valid one', function () {
        $tests = [
            'accept-language' => 'accept-language',
            'Accept-Language' => 'Accept-Language',
            'AcceptLanguage' => 'Accept-Language',
            'acceptLanguage' => 'accept-Language',
            'acceptlanguage' => 'acceptlanguage',
        ];

        foreach ($tests as $expect => $toBe) {
            expect(Header::sanitize($expect))->toBe($toBe);
        }
    });
});
