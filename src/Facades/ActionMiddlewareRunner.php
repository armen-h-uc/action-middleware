<?php

declare(strict_types=1);

namespace ActionMiddleware\Facades;

use ActionMiddleware\ActionMiddlewareManager;
use ActionMiddleware\Enums\ActionType;
use Illuminate\Support\Facades\Facade;

/**
 *
 * @package App\Facades
 *
 * @method static ActionMiddlewareManager run(ActionType $action, $args)
 *
 * @see     \ActionMiddleware\ActionMiddlewareManager
 * @uses    \ActionMiddleware\ActionMiddlewareManager::run()
 */
class ActionMiddlewareRunner extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ActionMiddlewareManager::class;
    }
}
