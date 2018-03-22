<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Infrastructure\Adapters\Illuminate;

use Illuminate\Container\EntryNotFoundException;
use Illuminate\Foundation\Application;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;

class ServiceContainerAdapter implements ServiceContainerContract
{
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application &$app)
    {

        $this->app =& $app;
    }

    /**
     * @param $id
     * @return mixed
     * @throws EntryNotFoundException
     */
    public function get($id)
    {
        try {
            return $this->app->get($id);
        } catch (EntryNotFoundException $e) {
            throw new EntryNotFoundException($id);
        }
    }

    public function has($id)
    {
        return $this->app->has($id);
    }

    public function bind($abstract, $concrete = null, $shared = false)
    {
        $this->app->bind($abstract,$concrete, $shared);
    }
}