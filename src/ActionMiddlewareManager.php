<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware;

use RuntimeException;
use Throwable;
use Uc\ActionMiddleware\Entities\ActionMiddleware;
use Uc\ActionMiddleware\Enums\ActionType;
use Uc\ActionMiddleware\Factories\ActionMiddlewareFactory;
use Uc\ActionMiddleware\Factories\ActionMiddlewareResponseFactory;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGatewayInterface;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\ActionMiddlewareRunnerGatewayInterface;
use Illuminate\Support\Collection;

class ActionMiddlewareManager
{
    public function __construct(
        protected ActionMiddlewareRunnerGatewayInterface $runnerGateway,
        protected ActionMiddlewareResponseFactory $responseFactory,
        protected ActionMiddlewareGatewayInterface $actionMiddlewareGateway,
    ) {
    }

    /**
     * @param \Uc\ActionMiddleware\Enums\ActionType $action
     * @param array                                 $payload
     *
     * @return void
     */
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

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getMiddlewares(): Collection
    {
        $actionMiddlewares = $this->actionMiddlewareGateway->getMiddlewares();

        return ActionMiddlewareFactory::createCollectionFromResponse($actionMiddlewares);
    }

    /**
     * @param \Uc\ActionMiddleware\Entities\ActionMiddleware $middleware
     * @param                                                $payload
     *
     * @return void
     */
    protected function processData(ActionMiddleware $middleware, $payload): void
    {
        $endpoint = $middleware->getEndpoint();
        $headers = $middleware->getHeaders();
        $type = $middleware->getType();
        $config = $middleware->getConfig();

        $data = [
            'payload' => $payload,
            'config'  => $config,
        ];

        $responseData = $this->runnerGateway->sendRequest($endpoint, $data, $headers);

        $this->responseFactory->createResponseByType($type, $payload, $responseData)->handle();
    }

    /**
     * @param \Uc\ActionMiddleware\Entities\ActionMiddleware $middleware
     * @param \Uc\ActionMiddleware\Enums\ActionType          $action
     *
     * @return bool
     */
    protected function isValidAction(ActionMiddleware $middleware, ActionType $action): bool
    {
        $actions = $middleware->getActions();

        return in_array($action, $actions);
    }
}
