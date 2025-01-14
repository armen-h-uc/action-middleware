<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Factories;

use Uc\ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponseInterface;
use Uc\ActionMiddleware\ActionMiddlewareResponse\ListenerResponse;
use Uc\ActionMiddleware\ActionMiddlewareResponse\ValidationResponse;
use Uc\ActionMiddleware\Enums\ActionMiddlewareType;

class ActionMiddlewareResponseFactory
{
    /**
     * @param \Uc\ActionMiddleware\Enums\ActionMiddlewareType $type
     * @param array                                           $inputData
     * @param array                                           $responseData
     *
     * @return \Uc\ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponseInterface
     */
    public function createResponseByType(
        ActionMiddlewareType $type,
        array $inputData,
        array $responseData
    ): ActionMiddlewareResponseInterface {
        return match ($type) {
            ActionMiddlewareType::LISTENER => $this->createListenerResponse($inputData, $responseData),
            ActionMiddlewareType::VALIDATION => $this->createValidationResponse($inputData, $responseData),
        };
    }

    /**
     * @param array $inputData
     * @param array $responseData
     *
     * @return \Uc\ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponseInterface
     */
    public function createValidationResponse(
        array $inputData,
        array $responseData
    ): ActionMiddlewareResponseInterface {
        return new ValidationResponse($inputData, $responseData);
    }

    /**
     * @param array $inputData
     * @param array $responseData
     *
     * @return \Uc\ActionMiddleware\ActionMiddlewareResponse\ActionMiddlewareResponseInterface
     */
    public function createListenerResponse(
        array $inputData,
        array $responseData
    ): ActionMiddlewareResponseInterface {
        return new ListenerResponse($inputData, $responseData);
    }
}
