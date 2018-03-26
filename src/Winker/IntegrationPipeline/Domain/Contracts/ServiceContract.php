<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface ServiceContract
{
    public function read(ServerRequestInterface $request): array;

    public function collection(ServerRequestInterface $request): array;

    public function byPortal(ServerRequestInterface $request): array;

    public function winkerModelTranslation(): string;
}