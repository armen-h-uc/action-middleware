<?php

declare(strict_types=1);

namespace ActionMiddleware;

use ActionMiddleware\Entities\ActionMiddleware;
use ActionMiddleware\Enums\ActionType;
use ActionMiddleware\Factories\ActionMiddlewareFactory;
use ActionMiddleware\Factories\ActionMiddlewareResponseFactory;
use ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGatewayInterface;
use ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\ActionMiddlewareRunnerGatewayInterface;
use Illuminate\Support\Collection;

class ActionMiddlewareManager
{
    /**
     * @var array|null
     */
    protected ?array $payload;

    protected ?string $operationName = null;

    public function __construct(
        protected ActionMiddlewareRunnerGatewayInterface $runnerGateway,
        protected ActionMiddlewareResponseFactory $responseFactory,
        protected ActionMiddlewareGatewayInterface $actionMiddlewareGateway,
    ) {
    }


    public function run(ActionType $action, array $payload): void
    {
        if (empty($payload)) {
            return;
        }

        $middlewares = $this->getMiddlewares();

        foreach ($middlewares as $middleware) {
            if (!$this->isValidAction($middleware, $action)) {
                $this->processData($middleware, $payload);
            }
        }
    }


    protected function getMiddlewares(): Collection
    {
        $applications = $this->actionMiddlewareGateway->getMiddlewares();

        return ActionMiddlewareFactory::createCollectionFromResponse($applications);
    }


    protected function processData(ActionMiddleware $middleware, $payload): void
    {
        $endpoint = $middleware->getEndpoint();
        $headers = $middleware->getHeaders();
        $type = $middleware->getType();

        $responseData = $this->runnerGateway->sendRequest($endpoint, $payload, $headers);
        //        dd($responseData);
        $responseData = [
            'success'  => false,
            'messages' => ['email' => 'Please provide a valid email address.']
        ];

        $this->responseFactory->createResponseByType($type, $payload, $responseData)->handle();
    }

    protected function isValidAction(ActionMiddleware $middleware, ActionType $action): bool
    {
        $actions = $middleware->getActions();

        return in_array($action, $actions);
    }
}
