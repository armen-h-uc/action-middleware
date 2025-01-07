<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\ActionMiddlewareResponse;

abstract class ActionMiddlewareResponse
{
    /**
     * @var bool
     */
    protected bool $isSuccess = false;

    /**
     * @var array|mixed
     */
    protected array $messages = [];

    /**
     * @var array
     */
    protected array $responseData = [];

    /**
     * @var array
     */
    protected array $inputData = [];

    /**
     * @return void
     */
    abstract public function handle(): void;

    public function __construct(
        array $inputData,
        array $responseData
    ) {
        $this->isSuccess = !!$responseData['success'] ?? false;
        $this->messages = $responseData['messages'] ?? [];
        $this->responseData = $responseData['data'] ?? [];
        $this->inputData = $inputData;
    }
}
