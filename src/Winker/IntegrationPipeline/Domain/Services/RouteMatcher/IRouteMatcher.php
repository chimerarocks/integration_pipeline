<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\RouteMatcher;

interface IRouteMatcher
{
    public function match(string $path): RouterMatcherResult;
}