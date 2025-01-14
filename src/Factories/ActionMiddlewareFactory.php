<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Factories;

use Illuminate\Support\Collection;
use Uc\ActionMiddleware\Enums\ActionMiddlewareType;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareStruct;

class ActionMiddlewareFactory
{
    /**
     * @param array $data
     *
     * @return \Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareStruct
     */
    public static function createFromResponse(array $data): ActionMiddlewareStruct
    {
        $actionMiddleware = new ActionMiddlewareStruct();

        $actionMiddleware->setProjectId((int)($data['projectId'] ?? 0));
        $actionMiddleware->setAlias($data['alias'] ?? '');
        $actionMiddleware->setEndpoint($data['endpoint'] ?? '');
        $actionMiddleware->setActive((bool)$data['active'] ?? false);
        $actionMiddleware->setType(ActionMiddlewareType::from($data['type']));
        $actionMiddleware->setActions(json_decode($data['actions'] ?? '[]', true) ?? []);
        $actionMiddleware->setHeaders(json_decode($data['headers'] ?? '[]', true) ?? []);
        $actionMiddleware->setConfig(json_decode($data['config'] ?? '[]', true) ?? []);

        return $actionMiddleware;
    }

    /**
     * @param array $actionMiddlewares
     *
     * @return \Illuminate\Support\Collection<ActionMiddlewareStruct>
     */
    public static function createCollectionFromResponse(array $actionMiddlewares): Collection
    {
        $collection = new Collection();

        foreach ($actionMiddlewares as $actionMiddleware) {
            $collection->add(self::createFromResponse($actionMiddleware));
        }

        return $collection;
    }
}
