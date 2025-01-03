<?php

declare(strict_types=1);

namespace ActionMiddleware\Gateways\ActionMiddlewareGateway;

interface ActionMiddlewareGatewayInterface
{
    /**
     * @return array|null
     */
    public function getMiddlewares(): ?array;
}
