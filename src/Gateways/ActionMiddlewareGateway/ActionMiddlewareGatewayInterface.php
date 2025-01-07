<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway;

interface ActionMiddlewareGatewayInterface
{
    /**
     * @return array|null
     */
    public function getMiddlewares(): ?array;
}
