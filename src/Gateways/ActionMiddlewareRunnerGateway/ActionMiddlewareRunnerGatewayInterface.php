<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway;

/**
 *
 */
interface ActionMiddlewareRunnerGatewayInterface
{
    /**
     * @param string     $url
     * @param array      $data
     * @param array|null $headers
     *
     * @return array
     */
    public function sendRequest(string $url, array $data, ?array $headers = []): array;
}
