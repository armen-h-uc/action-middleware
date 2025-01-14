<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\SchemaValidator;

class ListenerResponseSchemaValidator implements SchemaValidatorInterface
{
    public function validate(array $data): bool
    {
        return true;
    }
}
