<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Facades;

use Uc\ActionMiddleware\ActionMiddlewareManager;
use Uc\ActionMiddleware\Enums\ActionType;
use Illuminate\Support\Facades\Facade;

/**
 *
 * @package App\Facades
 *
 * @method static ActionMiddlewareManager run(ActionType $action, $args)
 *
 * @see     \Uc\ActionMiddleware\ActionMiddlewareManager
 * @uses    \Uc\ActionMiddleware\ActionMiddlewareManager::run()
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
