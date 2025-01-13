<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware;

use Uc\ActionMiddleware\Entities\ActionMiddleware;
use Uc\ActionMiddleware\Enums\ActionType;
use Uc\ActionMiddleware\Enums\ExcludedKey;
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
     * @param string|array                          $allowedKeys
     *
     * @return void
     */
    public function run(
        ActionType $action,
        array $payload,
        string|array $allowedKeys = '*'
    ): void {
        $filteredPayload = $this->payloadFilter($payload, $allowedKeys);

        $middlewares = $this->getMiddlewares();

        /** @var ActionMiddleware $middleware */
        foreach ($middlewares as $middleware) {
            if (!$this->isValidAction($middleware, $action) && $middleware->getActive()) {
                $this->processData($middleware, $filteredPayload);
            }
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getMiddlewares(): Collection
    {
        $actionMiddlewares = $this->actionMiddlewareGateway->getMiddlewares();

        if (empty($actionMiddlewares)) {
            return collect();
        }

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
            'payload' => (object)$payload,
            'config'  => (object)$config,
        ];

        $responseData = $this->runnerGateway->sendRequest($endpoint, $data, $headers);

        $this->responseFactory->createResponseByType($type, $payload, $responseData)->handle();
    }

    /**
     * @param array        $payload
     * @param string|array $allowedKeys
     *
     * @return array
     */
    protected function payloadFilter(array $payload, string|array $allowedKeys): array
    {
        $excludedKeys = ExcludedKey::getExcludedKeys();
        $filteredPayload = array_diff_key($payload, array_flip($excludedKeys));

        if ($allowedKeys === '*') {
            return $filteredPayload;
        }

        if (is_string($allowedKeys)) {
            $allowedKeys = [$allowedKeys];
        }

        return array_intersect_key($filteredPayload, array_flip($allowedKeys));
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
