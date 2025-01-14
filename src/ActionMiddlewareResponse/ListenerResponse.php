<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\ActionMiddlewareResponse;

class ListenerResponse implements ActionMiddlewareResponseInterface
{
    public function __construct(
        array $inputData,
        array $responseData
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
    }
}
