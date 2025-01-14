<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Factories;

use JsonSchema\Validator;
use Uc\ActionMiddleware\Enums\ActionMiddlewareType;
use Uc\ActionMiddleware\SchemaValidator\ListenerResponseSchemaValidator;
use Uc\ActionMiddleware\SchemaValidator\ValidationResponseSchemaValidator;
use Uc\ActionMiddleware\SchemaValidator\SchemaValidatorInterface;

class ResponseSchemaValidatorFactory
{
    public function __construct(protected Validator $validator)
    {
    }
    public function createSchemaValidatorByType(
        ActionMiddlewareType $type,
    ): SchemaValidatorInterface {
        return match ($type) {
            ActionMiddlewareType::LISTENER => $this->createListenerValidator(),
            ActionMiddlewareType::VALIDATION => $this->createValidationValidator(),
        };
    }

    /**
     * @return \Uc\ActionMiddleware\SchemaValidator\SchemaValidatorInterface
     */
    public function createListenerValidator(): SchemaValidatorInterface
    {
        return new ListenerResponseSchemaValidator();
    }

    /**
     * @return \Uc\ActionMiddleware\SchemaValidator\SchemaValidatorInterface
     */
    public function createValidationValidator(): SchemaValidatorInterface
    {
        return new ValidationResponseSchemaValidator($this->validator);
    }
}
