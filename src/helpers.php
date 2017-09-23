<?php

use TZK\Taiga\CurlRequest;

if (!function_exists('generate_taiga_auth_token')) {
    function generate_taiga_auth_token($baseUrl, array $credentials)
    {
        $request = new CurlRequest();
        $response = $request->send($baseUrl.'/auth', 'POST', $credentials);

        return $response->auth_token;
    }
}
