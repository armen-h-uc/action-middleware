<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\SchemaValidator;

use JsonSchema\Validator;
use Uc\ActionMiddleware\Exceptions\ActionMiddlewareDataException;

class MiddlewareSchemaValidator implements SchemaValidatorInterface
{
    protected object $schema;

    public function __construct(protected Validator $validator)
    {
        $schemaPath = __DIR__.'/../schemas/actionMiddleware/actionMiddleware-schema.json';

        $this->schema = json_decode(file_get_contents($schemaPath));
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

            throw new ActionMiddlewareDataException(
                'Action Middleware data does not validate. Violations: '.implode("\n", $errors)
            );
        }

        return true;
    }
}
