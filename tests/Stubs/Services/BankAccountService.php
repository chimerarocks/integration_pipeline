<?php
declare(strict_types=1);

namespace Test\Stubs\Services;

use Psr\Http\Message\ServerRequestInterface;
use Winker\Integration\Util\Model\Translation\Model\BankAccount;
use Winker\Integration\Util\Model\Translation\Model\Model;
use Winker\IntegrationPipeline\Domain\Contracts\ServiceContract;

class BankAccountService implements ServiceContract
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function winkerModelTranslation(): string
    {
        return BankAccount::class;
    }

    public function read(ServerRequestInterface $request): array
    {
        return ['read' => true];
    }

    public function collection(ServerRequestInterface $request): array
    {
        return ['collection' => true];
    }

    public function byPortal(ServerRequestInterface $request): array
    {
        return ['portal' => true];
    }
}