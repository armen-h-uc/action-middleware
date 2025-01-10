<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Entities;

use Uc\ActionMiddleware\Enums\ActionMiddlewareType;

class ActionMiddleware extends Entity
{
    /**
     * @var int|string
     */
    protected int|string $projectId;

    /**
     * @var string
     */
    protected string $alias;

    /**
     * @var string
     */
    protected string $endpoint;

    /**
     * @var bool
     */
    protected bool $active;

    /**
     * @var array
     */
    protected array $actions;

    /**
     * @var ActionMiddlewareType
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
     * @return int|string
     */
    public function getProjectId(): int|string
    {
        return $this->projectId;
    }

    /**
     * @param int|string $projectId
     *
     * @return void
     */
    public function setProjectId(int|string $projectId): void
    {
        $this->projectId = $projectId;
    }

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
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return void
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
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
     * @return \Uc\ActionMiddleware\Enums\ActionMiddlewareType
     */
    public function getType(): ActionMiddlewareType
    {
        return $this->type;
    }

    /**
     * @param \Uc\ActionMiddleware\Enums\ActionMiddlewareType $type
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
     * @param array|null $config
     *
     * @return void
     */
    public function setConfig(?array $config): void
    {
        $this->config = $config;
    }
}
