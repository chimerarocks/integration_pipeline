<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Routing;

use Winker\IntegrationPipeline\Domain\Services\Routing\Type\Type;

trait RouteAccess
{
    public function isCollectionRoute(): bool
    {
        return $this->type == Type::COLLECTION_ROUTE;
    }

    public function isReadRoute(): bool
    {
        return $this->type == Type::READ_ROUTE;
    }

    public function isByPortalRoute(): bool
    {
        return $this->type == Type::BY_PORTAL_ROUTE;
    }

    public function getRule(): string
    {
        $routeName = $this->name;
        if ($this->isCollectionRoute()) {
            return str_replace('%name%', $routeName, Rules::COLLECTION_RULE);
        }
        if ($this->isByPortalRoute()) {
            return str_replace('%name%', $routeName, Rules::BY_PORTAL_RULE);
        }
        if ($this->isReadRoute()) {
            return str_replace('%name%', $routeName, Rules::READ_RULE);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }
}