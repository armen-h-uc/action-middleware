<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway;

use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\Exceptions\UnableToGetActionMiddlewareException;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Throwable;

class RedisConnection implements ActionMiddlewareGatewayInterface
{
    /**
     * @var \Illuminate\Redis\Connections\PhpRedisConnection
     */
    protected PhpRedisConnection $connection;

    /**
     * @var string
     */
    protected string $setKey;

    public function __construct(
        PhpRedisConnection $connection,
        string $setKey,
    ) {
        $this->connection = $connection;
        $this->setKey = $setKey;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        $response = [];

        try {
            $actionMiddlewareStruct = new ActionMiddlewareStruct();

            $hashKeys = $this->connection->smembers($this->setKey);

            foreach ($hashKeys as $key) {
                $data = $this->connection->hGetAll($key);
                if (!empty($data)) {
                    $response[] = $actionMiddlewareStruct->setFromResponseData($data)->toArray();
                }
            }
        } catch (Throwable) {
            throw new UnableToGetActionMiddlewareException();
        }

        return $response;
    }
}
