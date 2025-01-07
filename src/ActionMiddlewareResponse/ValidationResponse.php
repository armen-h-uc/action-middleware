<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\ActionMiddlewareResponse;

use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

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
            throw new ValidationException($this->getValidator());
        }
    }

    /**
     * @return \Illuminate\Validation\Validator
     */
    protected function getValidator(): Validator
    {
        $rules = [];

        foreach ($this->messages as $field => $message) {
            $rules[$field] = function ($attribute, $value, $fail) use ($message): void {
                $fail($message);
            };
        }

        return ValidatorFacade::make($this->inputData, $rules);
    }
}
