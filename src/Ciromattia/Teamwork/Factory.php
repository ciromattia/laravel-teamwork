<?php

namespace Ciromattia\Teamwork;

use Ciromattia\Teamwork\Contracts\RequestableInterface;
use Ciromattia\Teamwork\Exceptions\ClassNotCreatedException;

class Factory
{
    protected $client;

    /**
     * @param RequestableInterface $client
     */
    public function __construct(RequestableInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     * @throws ClassNotCreatedException
     * @throws \ReflectionException
     */
    public function __call($method, $parameters)
    {
        $class = $this->getQualifiedName($method);
        if (!class_exists($class)) {
            throw new ClassNotCreatedException("Class $class could not be created.");
        }
        if ($this->paramIsId($parameters) == true) {
            return new $class($this->client, $parameters[0]);
        }

        return new $class($this->client);
    }

    /**
     * Get namespace
     *
     * @return string
     * @throws \ReflectionException
     */
    private function getNamespace()
    {
        $reflection = new \ReflectionClass($this);

        return $reflection->getNamespaceName();
    }

    /**
     * Get Fully Qualified Name
     *
     * build and return fully qualified name
     * for class to instantiate
     *
     * @param $method
     * @return string
     * @throws \ReflectionException
     */
    protected function getQualifiedName($method)
    {
        return $this->getNamespace() . '\\' . ucfirst($method);
    }

    /**
     * Parameter Has ID
     *
     * is there a parameter being passed in, and is it
     * an integer?
     *
     * @param $parameters
     * @return bool
     * @throws \InvalidArgumentException
     */
    protected function paramIsId($parameters)
    {
        if ($parameters == null) return null;

        // ensure id is numeric
        if ($parameters[0] != intval($parameters[0])) {
            throw new \InvalidArgumentException("[{$parameters[0]} ] is not a valid ID");
        }
        return true;
    }
}
