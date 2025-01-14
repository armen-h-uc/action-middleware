<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway;

interface ActionMiddlewareGatewayInterface
{
    /**
     * @return array
     */
    public function getMiddlewares(): array;
}
