<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\SchemaValidator;

use JsonSchema\Validator;
use Uc\ActionMiddleware\Exceptions\ValidationMiddlewareResponseDataException;

class ValidationResponseSchemaValidator implements SchemaValidatorInterface
{
    protected Validator $validator;
    protected object $schema;

    public function __construct(Validator $validator)
    {
        $schemaPath = __DIR__.'/../schemas/actionMiddlewareRunner/validation/response-schema.json';

        $this->schema = json_decode(file_get_contents($schemaPath));
        $this->validator = $validator;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data): bool
    {
        $this->validator->validate($data, $this->schema);

        if (!$this->validator->isValid()) {
            $errors = [];
            foreach ($this->validator->getErrors() as $error) {
                $errors[] = sprintf("[%s] %s", $error['property'], $error['message']);
            }

            throw new ValidationMiddlewareResponseDataException(
                'Validation Middleware data does not validate. Violations: '.implode("\n", $errors)
            );
        }

        return true;
    }
}
