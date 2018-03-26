<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Routing;

interface IRoute
{
    public function isCollectionRoute(): bool;

    public function isReadRoute(): bool;

    public function isByPortalRoute(): bool;

    public function getRule(): string;

    public function getName(): string;
}