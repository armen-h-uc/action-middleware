<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Uc\ActionMiddleware\Enums\ActionType;
use Uc\ActionMiddleware\Enums\ExcludedKey;
use Uc\ActionMiddleware\Exceptions\ActionMiddlewareRunException;
use Uc\ActionMiddleware\Factories\ActionMiddlewareFactory;
use Uc\ActionMiddleware\Factories\ActionMiddlewareResponseFactory;
use Uc\ActionMiddleware\Factories\ResponseSchemaValidatorFactory;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGatewayInterface;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareStruct;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\ActionMiddlewareRunnerGatewayInterface;
use Illuminate\Support\Collection;
use Uc\ActionMiddleware\SchemaValidator\MiddlewareSchemaValidator;

class ActionMiddlewareManager
{
    public function __construct(
        protected ActionMiddlewareRunnerGatewayInterface $runnerGateway,
        protected ActionMiddlewareResponseFactory $responseFactory,
        protected ActionMiddlewareGatewayInterface $actionMiddlewareGateway,
        protected MiddlewareSchemaValidator $middlewareSchemaValidator,
        protected ResponseSchemaValidatorFactory $responseSchemaValidatorFactory,
        protected LoggerInterface $logger,
    ) {
    }

    /**
     * @param \Uc\ActionMiddleware\Enums\ActionType $action
     * @param array                                 $payload
     * @param array                                 $allowedKeys
     *
     * @return void
     */
    public function run(
        ActionType $action,
        array $payload,
        array $allowedKeys = []
    ): void {
        $filteredPayload = $this->payloadFilter($payload, $allowedKeys);

        try {
            $middlewares = $this->getMiddlewares();

            foreach ($middlewares as $middleware) {
                if (!$this->isValidAction($middleware, $action) && $middleware->getActive()) {
                    $this->processData($middleware, $filteredPayload);
                }
            }
        } catch (ActionMiddlewareRunException $e) {
            $this->createLog((string)$e->getCode(), $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Support\Collection<ActionMiddlewareStruct>
     */
    protected function getMiddlewares(): Collection
    {
        try {
            $actionMiddlewares = $this->actionMiddlewareGateway->getMiddlewares();

            if (empty($actionMiddlewares)) {
                return collect();
            }

            $this->middlewareSchemaValidator->validate($actionMiddlewares);

            return ActionMiddlewareFactory::createCollectionFromResponse($actionMiddlewares);
        } catch (Throwable $e) {
            throw new ActionMiddlewareRunException(
                "Get Middleware failed: {$e->getMessage()}",
                Response::HTTP_BAD_GATEWAY,
                $e
            );
        }
    }

    /**
     * @param \Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareStruct $actionMiddleware
     * @param array                                                                        $payload
     *
     * @return void
     */
    protected function processData(ActionMiddlewareStruct $actionMiddleware, array $payload): void
    {
        try {
            $endpoint = $actionMiddleware->getEndpoint();
            $headers = $actionMiddleware->getHeaders();
            $type = $actionMiddleware->getType();
            $config = $actionMiddleware->getConfig();

            $data = [
                'payload' => (object)$payload,
                'config'  => (object)$config,
            ];

            $responseData = $this->runnerGateway->sendRequest($endpoint, $data, $headers);
            $this->responseSchemaValidatorFactory->createSchemaValidatorByType($type)->validate($responseData);
        } catch (Throwable $e) {
            throw new ActionMiddlewareRunException(
                "Process data failed: {$e->getMessage()}",
                Response::HTTP_BAD_GATEWAY,
                $e
            );
        }

        $this->responseFactory->createResponseByType($type, $payload, $responseData)->handle();
    }

    /**
     * @param array $payload
     * @param array $allowedKeys
     *
     * @return array
     */
    protected function payloadFilter(array $payload, array $allowedKeys): array
    {
        $excludedKeys = ExcludedKey::getExcludedKeys();
        $filteredPayload = array_diff_key($payload, array_flip($excludedKeys));

        if (empty($allowedKeys)) {
            return $filteredPayload;
        }

        return array_intersect_key($filteredPayload, array_flip($allowedKeys));
    }

    /**
     * @param \Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareStruct $actionMiddleware
     * @param \Uc\ActionMiddleware\Enums\ActionType                                        $action
     *
     * @return bool
     */
    protected function isValidAction(ActionMiddlewareStruct $actionMiddleware, ActionType $action): bool
    {
        $actions = $actionMiddleware->getActions();

        return in_array($action, $actions);
    }

    /**
     * @param string $code
     * @param string $message
     *
     * @return void
     */
    protected function createLog(string $code, string $message): void
    {
        $this->logger->error('Error run action middleware.'.$code, [
            'message' => $message,
            'code'    => $code,
        ]);
    }
}
