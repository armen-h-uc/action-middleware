<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\ActionMiddlewareResponse;

class ListenerResponse extends ActionMiddlewareResponse
{
    public function __construct(
        array $inputData,
        array $responseData
    ) {
        parent::__construct($inputData, $responseData);
    }

    /**
     * @return void
     */
    public function handle(): void
    {
    }
}
