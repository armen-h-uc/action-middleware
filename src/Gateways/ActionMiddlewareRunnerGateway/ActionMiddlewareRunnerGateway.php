<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Uc\ActionMiddleware\Exceptions\BadGatewayException;
use Uc\ActionMiddleware\Exceptions\UnauthorizedResponseException;

class ActionMiddlewareRunnerGateway implements ActionMiddlewareRunnerGatewayInterface
{
    public function __construct(protected Client $httpClient)
    {
    }

    /**
     * @param string $url
     * @param array  $data
     * @param array  $headers
     *
     * @return array
     * @throws \Uc\ActionMiddleware\Exceptions\BadGatewayException
     */
    public function sendRequest(string $url, array $data, array $headers): array
    {
        try {
            $response = $this->httpClient->request('POST', $url, [
                'headers' => $headers,
                'json'    => $data
            ]);

            return $this->validateResponse($response);
        } catch (Throwable $e) {
            throw new BadGatewayException($e->getMessage());
        }
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return array
     * @throws \Uc\ActionMiddleware\Exceptions\BadGatewayException
     * @throws \Uc\ActionMiddleware\Exceptions\UnauthorizedResponseException
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
