<?php

declare(strict_types=1);

namespace ActionMiddleware\Gateways\ActionMiddlewareGateway;

use ActionMiddleware\Enums\ActionMiddlewareType;
use Illuminate\Contracts\Support\Arrayable;

class ActionMiddlewareStruct implements Arrayable
{
    /**
     * @var string
     */
    protected string $alias;
    /**
     * @var int
     */
    protected int $projectId;
    /**
     * @var string
     */
    protected string $endpoint;
    /**
     * @var array
     */
    protected array $actions;

    /**
     * @var \ActionMiddleware\Enums\ActionMiddlewareType
     */
    protected ActionMiddlewareType $type;
    /**
     * @var array
     */
    protected array $headers;
    /**
     * @var array
     */
    protected array $config;


    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return void
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @param int $projectId
     *
     * @return void
     */
    public function setProjectId(int $projectId): void
    {
        $this->projectId = $projectId;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     *
     * @return void
     */
    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return array
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @param array $actions
     *
     * @return void
     */
    public function setActions(array $actions): void
    {
        $this->actions = $actions;
    }

    /**
     * @return \ActionMiddleware\Enums\ActionMiddlewareType
     */
    public function getType(): ActionMiddlewareType
    {
        return $this->type;
    }

    /**
     * @param \ActionMiddleware\Enums\ActionMiddlewareType $type
     *
     * @return void
     */
    public function setType(ActionMiddlewareType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     *
     * @return void
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     *
     * @return void
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function setFromRequestData(array $data): static
    {
        $this->alias = $data['alias'] ?? '';
        $this->projectId = (int)($data['projectId'] ?? 0);
        $this->endpoint = $data['endpoint'] ?? '';
        $this->type = $data['type'] instanceof ActionMiddlewareType
            ? $data['type']
            : ActionMiddlewareType::from($data['type']);
        $this->actions = json_encode($data['actions']) ?? [];
        $this->headers = json_encode($data['headers']) ?? [];
        $this->config = json_encode($data['config']) ?? [];

        return $this;
    }

    public function setFromResponseData(array $data): static
    {
        $this->alias = $data['alias'] ?? '';
        $this->projectId = (int)($data['projectId'] ?? 0);
        $this->endpoint = $data['endpoint'] ?? '';
        $this->type = $data['type'] instanceof ActionMiddlewareType
            ? $data['type']
            : ActionMiddlewareType::from($data['type']);
        $this->actions = json_decode($data['actions'] ?? '[]', true) ?? [];
        $this->headers = json_decode($data['headers'] ?? '[]', true) ?? [];
        $this->config = json_decode($data['config'] ?? '[]', true) ?? [];

        return $this;
    }

    public function toArray(): array
    {
        return [
            'alias'     => $this->alias,
            'projectId' => $this->projectId,
            'endpoint'  => $this->endpoint,
            'type'      => $this->type,
            'actions'   => $this->actions,
            'headers'   => $this->headers,
            'config'    => $this->config,
        ];
    }
}
