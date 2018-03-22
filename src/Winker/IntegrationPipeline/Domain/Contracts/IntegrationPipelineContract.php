<?php
/**
 * Created by PhpStorm.
 * User: jp
 * Date: 11/03/18
 * Time: 00:03
 */

namespace Winker\IntegrationPipeline\Domain\Contracts;


use Psr\Http\Message\ServerRequestInterface;

interface IntegrationPipelineContract
{
    public function process();
}