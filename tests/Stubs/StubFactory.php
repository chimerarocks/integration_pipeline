<?php
declare(strict_types=1);

namespace Test\Stubs;

use Psr\Container\ContainerInterface;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;

class StubFactory
{
    private $asClassName;

    private $toImplementClassName;

    /**
     * @var ClassFactory
     */
    private $classFactory;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        ClassFactory $classFactory,
        ServiceContainerContract $container
    )
    {
        $this->classFactory = $classFactory;
        $this->container = $container;
    }

    public function toImplement(string $className)
    {
        $this->toImplementClassName = $className;
        $this->classFactory->implementing($className);
    }

    public function asClass(string $className)
    {
        $this->asClassName = $className;
        $this->classFactory->asClass($className);
        return $this;
    }

    public function implementing(string ...$interfaces)
    {
        $this->classFactory->implementing(...$interfaces);
        return $this;
    }

    public function withAttributes(array $attributes)
    {
        $this->classFactory->withAttributes($attributes);
        return $this;
    }

    public function withMethod(string $name, \Closure $method)
    {
        $this->classFactory->withMethod($name, $method);
        return $this;
    }

    public function make()
    {
        $this->classFactory->make();
        $this->container->bind($this->toImplementClassName, $this->asClassName);
    }
}