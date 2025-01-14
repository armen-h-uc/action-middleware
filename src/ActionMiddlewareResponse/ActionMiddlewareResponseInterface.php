<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\ActionMiddlewareResponse;

interface ActionMiddlewareResponseInterface
{
    public function handle(): void;
}
