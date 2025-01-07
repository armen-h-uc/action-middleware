<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway;

use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\Exceptions\UnableToGetActionMiddlewareException;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Throwable;

class ActionMiddlewareGateway implements ActionMiddlewareGatewayInterface
{
    /**
     * @var \Illuminate\Redis\Connections\PhpRedisConnection
     */
    protected PhpRedisConnection $connection;

    public function __construct(
        PhpRedisConnection $connection,
    ) {
        $this->connection = $connection;
    }

    /**
     * @return array|null
     */
    public function getMiddlewares(): ?array
    {
        try {
            $actionMiddlewareStruct = new ActionMiddlewareStruct();

            $hashKeys = $this->connection->smembers('action-middlewares');
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
