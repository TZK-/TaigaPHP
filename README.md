# TaigaPHP

[![Latest Stable Version](https://poser.pugx.org/tzk/taiga-php/version)](https://packagist.org/packages/tzk/taiga-php) [![Total Downloads](https://poser.pugx.org/tzk/taiga-php/downloads)](https://packagist.org/packages/tzk/taiga-php) [![License](https://poser.pugx.org/tzk/taiga-php/license)](https://packagist.org/packages/tzk/taiga-php)


TaigaPHP is a PHP wrapper used to handle the Taiga.io API easily.

(If you want to use this library with Laravel 5.x, take a look at https://github.com/TZK-/TaigaLaravel)

# Installation (Composer)

TaigaPHP has been written for PHP >=5.3 and and earlier versions and you need to ensure that the PHP CURL extension is activated and also working.

To install the library, just run the command below:
```sh
    composer require tzk/taiga-php
```
The Library has been added into your dependencies and ready to be used.

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

echo TZK\Taiga\Taiga::getAuthToken($baseUrl, $credentials);
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

    public function __construct(RestClient $root)
    {
        parent::__construct($root, 'issue-types');
    }

    public function getList(array $param)
    {
        return $this->get(null, $param);
    }

    public function create(array $data) {
        return $this->post(null, [], $data);
    }

    public function getById($id)
    {
        return $this->get($id);
    }

    public function edit($id, array $data) {
        return $this->put($id, [], $data);
    }

    public function remove($id) {
        return $this->delete($id);
    }

    public function vote($id) {
        return $this->post(sprintf('%s/upvote', $id));
    }

    public function bulkUpdateOrder(array $data) {
        return $this->post('bulk_update_order', [], $data);
    }
}
```
As you can see, it is very simple to add your own methods and interact with the API itself.

If you wanna add new services, the only thing you have to do is to create a new class inside the Service folder and extends the **TZK\Taiga\Service** class.

TaigaPHP will automatically load the service for you and it will be accessible from a public method which has the same name as your service.

# Example

## Get issue types
```php
/* 
 * You can specify the locale to use giving language code
 * @see https://taigaio.github.io/taiga-doc/dist/api.html#object-locale-detail
 */
$taiga = new TZK\Taiga\Taiga($baseUrl, $auth_token, 'fr');

// Access with the 'issueTypes' public method
$issues = $taiga->issueTypes()->getList(['project' => $projectId]);
```
## Create a new issue
```php
// Access with the 'issues' public method
$issues = $taiga->issues()->create(['project' => $projectId, 'subject' => 'My super issue']);
```
# Contributing

TaigaPHP offers a great starting coverage, but there are some endpoints missing. 

If you use this wrapper, please share if you added new endpoints / features by opening a new PR.
