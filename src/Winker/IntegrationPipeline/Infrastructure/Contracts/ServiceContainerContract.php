<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Infrastructure\Contracts;

use Psr\Container\ContainerInterface;

interface ServiceContainerContract extends ContainerInterface
{
    /**
     * Register a binding with the container.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @param  bool  $shared
     * @return void
     */
    public function bind($abstract, $concrete = null, $shared = false);

    public function get($id);
}