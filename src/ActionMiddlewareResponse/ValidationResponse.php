<?php

declare(strict_types=1);

namespace ActionMiddleware\ActionMiddlewareResponse;

use Illuminate\Validation\ValidationException;

class ValidationResponse extends ActionMiddlewareResponse
{
    public function __construct(
        array $inputData,
        array $responseData
    ) {
        parent::__construct($inputData, $responseData);
    }


    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(): void
    {
        if (!$this->isSuccess) {
            throw ValidationException::withMessages($this->messages);
        }
    }
}
