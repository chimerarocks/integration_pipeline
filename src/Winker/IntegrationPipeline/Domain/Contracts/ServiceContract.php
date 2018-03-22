<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Contracts;

interface ServiceContract
{
    public function run(): array;
}