<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway;

use Illuminate\Contracts\Config\Repository;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\Exceptions\UnableToGetActionMiddlewareException;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Throwable;

class ActionMiddlewareGateway implements ActionMiddlewareGatewayInterface
{
    /**
     * @var \Illuminate\Redis\Connections\PhpRedisConnection
     */
    protected PhpRedisConnection $connection;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected Repository $configRepository;

    public function __construct(
        PhpRedisConnection $connection,
        Repository $configRepository,
    ) {
        $this->connection = $connection;
        $this->configRepository = $configRepository;
    }

    /**
     * @return array|null
     */
    public function getMiddlewares(): ?array
    {
        try {
            $actionMiddlewareStruct = new ActionMiddlewareStruct();
            $key = $this->configRepository->get('action-middleware.setKey');

            $hashKeys = $this->connection->smembers($key);
            $response = [];

            foreach ($hashKeys as $key) {
                $data = $this->connection->hGetAll($key);
                $response[] = $actionMiddlewareStruct->setFromResponseData($data)->toArray();
            }
        } catch (Throwable) {
            throw new UnableToGetActionMiddlewareException();
        }

        return $response;
    }
}
