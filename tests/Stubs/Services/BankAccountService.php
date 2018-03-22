<?php
declare(strict_types=1);

namespace Test\Stubs\Services;

use Psr\Http\Message\ServerRequestInterface;
use Winker\Integration\Util\Model\Translation\Model\BankAccount;
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

    public function winkerModelTranslation()
    {
        return BankAccount::class;
    }

    public function run(): array
    {
        return ['run' => true];
    }
}