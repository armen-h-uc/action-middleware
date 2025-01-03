<?php

declare(strict_types=1);

namespace ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway;

use ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\Exceptions\BadGatewayException;
use ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\Exceptions\UnauthorizedResponseException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ActionMiddlewareRunnerGateway implements ActionMiddlewareRunnerGatewayInterface
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected Client $httpClient;

    /**
     * @var array
     */
    protected array $headers;

    public function __construct(Client $client)
    {
        $this->httpClient = $client;
    }

    /**
     * @param string     $url
     * @param array      $data
     * @param array|null $headers
     *
     * @return array
     * @throws \ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\Exceptions\BadGatewayException
     * @throws \ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\Exceptions\UnauthorizedResponseException
     */
    public function sendRequest(string $url, array $data = [], ?array $headers = []): array
    {
        try {
            $response = $this->httpClient->post($url, [
                'json'    => $data,
                'headers' => $headers

            ]);
        } catch (Throwable $e) {
            throw new RuntimeException("Request failed: {$e->getMessage()}", 0, $e);
        }

        return $this->validateResponse($response);
    }


    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return array
     * @throws \ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\Exceptions\BadGatewayException
     * @throws \ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\Exceptions\UnauthorizedResponseException
     */
    protected function validateResponse(ResponseInterface $response): array
    {
        if ($response->getStatusCode() === Response::HTTP_OK) {
            return json_decode((string)$response->getBody(), true);
        }

        if ($response->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
            throw new UnauthorizedResponseException(
                'Unauthorized',
                Response::HTTP_UNAUTHORIZED
            );
        }

        throw new BadGatewayException(
            'Bad gateway',
            Response::HTTP_BAD_GATEWAY
        );
    }
}
