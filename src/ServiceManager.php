<?php

namespace TZK\Taiga;

use TZK\Taiga\Exceptions\TaigaException;

class ServiceManager
{
    /**
     * @var array
     */
    protected $services = [];

    /**
     * @var TZK\Taiga\RestClient
     */
    protected $client;

    public function __construct(RestClient $client)
    {
        $this->client = $client;
        $this->loadServices();
    }

    protected function loadServices()
    {
        foreach (glob(__DIR__.'/Services/*.php') as $service) {
            $basename = basename($service, '.php');
            $class = __NAMESPACE__.'\\Services\\'.$basename;

            try {
                $this->add($this->build($class));
            } catch (TaigaException $e) {
                continue;
            }
        }
    }

    protected function add(Service $service)
    {
        $classNameParts = explode('\\', get_class($service));
        $className = $classNameParts[count($classNameParts) - 1];

        $this->services[lcfirst($className)] = $service;

        return $this;
    }

    protected function build($class)
    {
        if (class_exists($class)) {
            throw new TaigaException("Unable to find the service class '$class'.");
        }

        $instance = new $class($this->client);
        if (!$instance instanceof Service) {
            throw new TaigaException("The class '$class' should be a ".Service::class.' instance.');
        }

        return $instance;
    }

    private function get($name)
    {
        if (!$this->has($name)) {
            throw new TaigaException("The service $name is not defined");
        }

        return $this->services[$name];
    }

    protected function has($name)
    {
        return isset($this->services[$name]);
    }
}
