# TaigaPHP

[![Build Status](https://travis-ci.org/TZK-/TaigaPHP.svg?branch=master)](https://travis-ci.org/TZK-/TaigaPHP) [![Latest Stable Version](https://poser.pugx.org/tzk/taiga-php/version)](https://packagist.org/packages/tzk/taiga-php) [![Total Downloads](https://poser.pugx.org/tzk/taiga-php/downloads)](https://packagist.org/packages/tzk/taiga-php) [![License](https://poser.pugx.org/tzk/taiga-php/license)](https://packagist.org/packages/tzk/taiga-php)


TaigaPHP is a PHP wrapper used to handle the Taiga.io API easily.

(If you want to use this library with Laravel 5.x, take a look at https://github.com/TZK-/TaigaLaravel)

# Installation (Composer)

TaigaPHP has been written and *tested* for PHP >=5.5 and and earlier versions. The only constraint is to have the cURL extension enabled.

To install the library, just run the command below:
```sh
composer require tzk/taiga-php
```

# Authentication

To send HTTP request to the API, you'll need to generate an Auth token.

The wrapper has a function to help you and you can just do like the code below or see https://taigaio.github.io/taiga-doc/dist/api.html#_authentication:
```php
// The API Url
$baseUrl = 'https://api.taiga.io/api/v1/';

// The credentials used for the authentification
$credentials = [
    'username' => 'USERNAME',
    'password' => 'PASSWORD',
    'type'    => 'normal'
];

echo generate_taiga_auth_token($baseUrl, $credentials);
```

# Get Taiga instance
```php
$request = TZK\Taiga\CurlRequest();

$headers = [
    'language' => 'fr',
    'x-disable-pagination' => true
];

$taiga = new TZK\Taiga\Taiga($request, $baseUrl, $auth_token, $headers);
```

# Change configuration on the fly

You can change the configuration through HTTP headers on the fly.

You just need to call magic method which has the same name as the header you wanna set prefixed by 'set'.

Some headers are composed by multiple words separated by dashed (Ex. Accept-Language).

To get it works, you should write the header name without dashes and in a camel-case format.

## Example

```php
$taiga->setAcceptLanguage('fr')->setAuthorization('Bearer ' . $auth_token);
```

To ease changing auth token or language on the fly, you can use shortcuts specified in *src/config/header_shortcuts.php*

```php
// In header_shortcuts.php
return [
    'language' => [
        'header' => 'Accept-Language',
    ],
    'authToken' => [
        'header' => 'Authorization',
        'prefix' => 'Bearer ',
    ],
];

// Will produce the same as the previous example.
$taiga->setLanguage('fr')->setAuthToken($token);
```

# Register a new service

The wrapper is based on 'Services' which wrap the API calls.
```php
<?php

namespace TZK\Taiga\Services;

use TZK\Taiga\RestClient;
use TZK\Taiga\Service;

class IssueTypes extends Service
{
    public function __construct(RestClient $taiga)
    {
        parent::__construct($taiga, 'issue-types');
    }

    public function getList(array $param)
    {
        return $this->get(null, $param);
    }

    public function create(array $data)
    {
        return $this->post(null, [], $data);
    }

    public function getById($id)
    {
        return $this->get($id);
    }

    public function edit($id, array $data)
    {
        return $this->put($id, [], $data);
    }

    public function remove($id)
    {
        return $this->delete($id);
    }

    public function vote($id)
    {
        return $this->post(sprintf('%s/upvote', $id));
    }

    public function bulkUpdateOrder(array $data)
    {
        return $this->post('bulk_update_order', [], $data);
    }
}

```
As you can see, it is very simple to add your own methods and interact with the API itself.

If you wanna add new services, the only thing you have to do is to create a new class inside the Service folder and extends the **TZK\Taiga\Service** class.

TaigaPHP will automatically load the service for you and it will be accessible from a public method which has the same name as your service.

# Examples

## Get issue types
```php
// Access with the 'issueTypes' public method
$issues = $taiga->issueTypes()->getList(['project' => $projectId]);
```
## Create a new issue
```php
// Access with the 'issues' public method
$issues = $taiga->issues()->create(['project' => $projectId, 'subject' => 'My super issue']);
```
# Supported features

- Applications
- Application Tokens
- Epics
- Issues
- Issue Statuses
- Issue Types
- Priorities
- Projects
- Resolvers
- Severities
- Users
- UserStories

# Tests

The library has been tested with [Kahlan](https://github.com/kahlan/kahlan).
If you want to run tests just run the command:

```sh
./vendor/bin/kahlan
```

At the moment, the tests are covering the main fatures of the wrapper.

# Contributing

TaigaPHP offers a great starting coverage, but there are some endpoints/tests missing.

If you use this wrapper, feel free to share if you have found bugs or added new endpoints / features or tests by opening a new PR.
