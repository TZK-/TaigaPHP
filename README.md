# Taiga SDK

TaigaPHP is a PHP wrapper used to handle the Taiga.io API easily.

# Installation (Composer)

SDK has been written for PHP 5.3 and and earlier versions and you need to ensure that the PHP CURL extension is activated and working.

To install the library, just run the command below:
``` sh
    composer install taiga-php/taiga-php
```
The Library has been added into your dependencies and ready to be used.

# Authentication

To send HTTP request to the API, you'll need to generate an auth token.

The wrapper has a function to help you and you can just do like the code below or see https://taigaio.github.io/taiga-doc/dist/api.html#_authentication:
``` php
    <?php
        // The API Url
        $baseUrl = 'https://api.taiga.io/api/v1/';
        
        // The credentials used for the authentification
        $credentials = [
            'username' => 'USERNAME',
            'password' => 'PASSWORD',
            'type'    => 'normal'
        ];
        
        echo Taiga\Taiga::getAuthToken($baseUrl, $credentials);
    ?>
```
# Example

## Get issues
``` php
    <?php
        $taiga = new Taiga\Taiga($baseUrl, $auth_token);
        $issues = $taiga->issues->getAll(['project' => $projectId]);
    ?>
```
## Create issue
``` php
    <?php
        $issues = $taiga->issues->create(['project' => $projectId, 'subject' => 'My super issue']);
    ?>
```
# Register a new service

The wrapper is based on 'Services' which wrap the API.
``` php
    <?php

    namespace Taiga\Service;

    use Taiga\Service;

    class IssueTypesService extends Service
    {

        public function __construct($root)
        {
            // The base url used for the requests https://api.taiga.io/api/v1/issue-type
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
As you can see, it is very simple to add your own methods. The only thing you need is to create a new service and to register this one into the Taiga.php class and create a public attribute to access to the service.

``` php
    <?php

    namespace Taiga;
    
    class Taiga extends RestClient {
    
        public $issues;
        public $issueStatuses;
        public $issueTypes;
        public $priorities;
        public $projects;
        public $severities;
        public $users;
        // ...
        
        /**
         * Taiga constructor.
         *
         * @param $baseUrl the API base URL
         * @param $token the public API token
         *
         * @throws Exception
         */
        public function __construct($baseUrl, $token) {
            parent::__construct($baseUrl, $token);
            $this->curl->setHeader('Authorization', 'Bearer ' . $token);
            
            // Add service names
            $services = ['issues', 'issueStatuses', 'issueTypes', 'priorities', 'projects', 'severities', 'users'];
            foreach ($services as $service) {
                $class = 'Taiga\\Service\\' . ucwords($service) . 'Service';
                $this->{$service} = new $class($this);
            }
        }
        
        // ...
    }
```