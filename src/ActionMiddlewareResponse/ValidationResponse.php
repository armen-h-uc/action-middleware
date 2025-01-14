<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\ActionMiddlewareResponse;

use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class ValidationResponse implements ActionMiddlewareResponseInterface
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
    public function __construct(
        array $inputData,
        array $responseData
    ) {
        $this->isSuccess = !!$responseData['success'];
        $this->messages = $responseData['messages'];
        $this->responseData = $responseData['data'];
        $this->inputData = $inputData;
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
