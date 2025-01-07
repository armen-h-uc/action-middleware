<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Factories;

use Uc\ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponse;
use Uc\ActionMiddleware\ActionMiddlewareResponse\ListenerResponse;
use Uc\ActionMiddleware\ActionMiddlewareResponse\ValidationResponse;
use Uc\ActionMiddleware\Enums\ActionMiddlewareType;

class ActionMiddlewareResponseFactory
{
    /**e
     *
     * @param \Uc\ActionMiddleware\Enums\ActionMiddlewareType $type
     * @param array                                           $inputData
     * @param array                                           $responseData
     *
     * @return \Uc\ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponse
     */
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
     * @return \Uc\ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponse
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
     * @return \Uc\ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponse
     */
    public function createListenerResponse(
        array $inputData,
        array $responseData
    ): ActionMiddlewareResponse {
        return new ListenerResponse($inputData, $responseData);
    }
}
