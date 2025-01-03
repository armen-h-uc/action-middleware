<?php

declare(strict_types=1);

namespace ActionMiddleware\Factories;

use ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponse;
use ActionMiddleware\ActionMiddlewareResponse\ListenerResponse;
use ActionMiddleware\ActionMiddlewareResponse\ValidationResponse;
use ActionMiddleware\Enums\ActionMiddlewareType;

class ActionMiddlewareResponseFactory
{
    public function createResponseByType(
        ActionMiddlewareType $type,
        array $inputData,
        array $responseData
    ): ActionMiddlewareResponse {
        return match ($type) {
            ActionMiddlewareType::LISTENER => $this->createListenerResponse($inputData, $responseData),
            ActionMiddlewareType::VALIDATION => $this->createValidationResponse($inputData, $responseData),
        };
    }

    /**
     * @param array $inputData
     * @param array $responseData
     *
     * @return \ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponse
     */
    public function createValidationResponse(
        array $inputData,
        array $responseData
    ): ActionMiddlewareResponse {
        return new ValidationResponse($inputData, $responseData);
    }

    /**
     * @param array $inputData
     * @param array $responseData
     *
     * @return \ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponse
     */
    public function createListenerResponse(
        array $inputData,
        array $responseData
    ): ActionMiddlewareResponse {
        return new ListenerResponse($inputData, $responseData);
    }
}
