<?php

use TZK\Taiga\Requests\CurlRequest;

if (!function_exists('generate_taiga_auth_token')) {
    function generate_taiga_auth_token($baseUrl, array $credentials)
    {
        $request = new CurlRequest();
        $response = $request->send($baseUrl.'/auth', 'POST', $credentials);

        return $response->auth_token;
    }
}
