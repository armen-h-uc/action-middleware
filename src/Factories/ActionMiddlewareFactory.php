<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Factories;

use Uc\ActionMiddleware\Entities\ActionMiddleware;
use Illuminate\Support\Collection;

class ActionMiddlewareFactory
{
    /**
     * @param array $applicationData
     *
     * @return \Uc\ActionMiddleware\Entities\ActionMiddleware
     */
    public static function createFromResponse(array $applicationData): ActionMiddleware
    {
        $actionApplication = new ActionMiddleware();

        $actionApplication->setProjectId($applicationData['projectId']);
        $actionApplication->setAlias($applicationData['alias']);
        $actionApplication->setEndpoint($applicationData['endpoint']);
        $actionApplication->setActions($applicationData['actions']);
        $actionApplication->setType($applicationData['type']);
        $actionApplication->setHeaders($applicationData['headers']);
        $actionApplication->setConfig($applicationData['config'] ?? null);

        return $actionApplication;
    }

    /**
     * @param array $actionApplications
     *
     * @return \Illuminate\Support\Collection
     */
    public static function createCollectionFromResponse(array $actionApplications): Collection
    {
        $collection = new Collection();

        foreach ($actionApplications as $applicationData) {
            $collection->add(self::createFromResponse($applicationData));
        }

        return $collection;
    }
}
