<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Factories;

use Uc\ActionMiddleware\Entities\ActionMiddleware;
use Illuminate\Support\Collection;

class ActionMiddlewareFactory
{
    /**
     * @param array $actionMiddlewareData
     *
     * @return \Uc\ActionMiddleware\Entities\ActionMiddleware
     */
    public static function createFromResponse(array $actionMiddlewareData): ActionMiddleware
    {
        $actionMiddleware = new ActionMiddleware();

        $actionMiddleware->setProjectId($actionMiddlewareData['projectId']);
        $actionMiddleware->setAlias($actionMiddlewareData['alias']);
        $actionMiddleware->setEndpoint($actionMiddlewareData['endpoint']);
        $actionMiddleware->setActive($actionMiddlewareData['active'] ?? false);
        $actionMiddleware->setType($actionMiddlewareData['type']);
        $actionMiddleware->setActions($actionMiddlewareData['actions'] ?? []);
        $actionMiddleware->setHeaders($actionMiddlewareData['headers'] ?? []);
        $actionMiddleware->setConfig($actionMiddlewareData['config'] ?? null);

        return $actionMiddleware;
    }

    /**
     * @param array $actionMiddlewares
     *
     * @return \Illuminate\Support\Collection
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
