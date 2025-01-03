<?php

declare(strict_types=1);

namespace ActionMiddleware\Factories;

use ActionMiddleware\Entities\ActionMiddleware;
use ActionMiddleware\Enums\ActionMiddlewareType;
use Illuminate\Support\Collection;

class ActionMiddlewareFactory
{
    public static function createFromResponse(array $applicationData): ActionMiddleware
    {
        $actionApplication = new ActionMiddleware();

        $actionApplication->setProjectId($applicationData['projectId']);
        $actionApplication->setAlias($applicationData['alias']);
        $actionApplication->setEndpoint($applicationData['endpoint']);
        $actionApplication->setActions($applicationData['actions']);
        $actionApplication->setType(ActionMiddlewareType::from($applicationData['type']));
        $actionApplication->setHeaders($applicationData['headers']);
        $actionApplication->setConfig($applicationData['config'] ?? null);

        return $actionApplication;
    }

    public static function createCollectionFromResponse(array $actionApplications): Collection
    {
        $collection = new Collection();

        foreach ($actionApplications as $applicationData) {
            $collection->add(self::createFromResponse($applicationData));
        }

        return $collection;
    }
}
