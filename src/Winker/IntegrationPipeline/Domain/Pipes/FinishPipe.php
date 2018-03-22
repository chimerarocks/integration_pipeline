<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Pipes;

use Psr\Http\Message\ServerRequestInterface;

class FinishPipe implements IFinishPipe
{
    public function handle(ServerRequestInterface $request, \Closure $next)
    {
        $data = $request->getAttribute(ITransformPipe::class);
        return $next($data);
    }
}