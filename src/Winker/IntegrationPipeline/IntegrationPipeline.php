<?php
/**
 * Created by PhpStorm.
 * User: jp
 * Date: 09/03/18
 * Time: 18:58
 */

namespace Winker\IntegrationPipeline;

use Illuminate\Pipeline\Pipeline;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Contracts\IntegrationPipelineContract;
use Winker\IntegrationPipeline\Domain\Pipes\IFinishPipe;
use Winker\IntegrationPipeline\Domain\Pipes\IConsumePipe;
use Winker\IntegrationPipeline\Domain\Pipes\ITransformPipe;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;

class IntegrationPipeline implements IntegrationPipelineContract
{
    private $pipes = [
        IConsumePipe::class,
        ITransformPipe::class,
        IFinishPipe::class
    ];

    private $pipeline;
    /**
     * @var ServerRequestInterface
     */
    private $request;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        ServiceContainerContract $container,
        ServerRequestInterface $request,
        Pipeline $pipeline
    )
    {
        $this->request = $request;
        $this->container = $container;
        $this->pipeline = $pipeline;
    }

    public function process()
    {
        $this->buildPipeline();
        $result = $this->startPipeline();
        return $result;
    }

    private function startPipeline()
    {
        return $this->pipeline
            ->then(function ($content) {
                return $content;
            });
    }

    private function buildPipeline()
    {
        $this->pipeline
            ->send($this->request)
            ->through($this->pipes);
    }
}