<?php

declare(strict_types=1);

namespace ActionMiddleware\ActionMiddlewareResponse;

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
