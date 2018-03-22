<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Pipes;


use Psr\Http\Message\ServerRequestInterface;

interface IPipe
{
    public function handle(ServerRequestInterface $request, \Closure $next);
}