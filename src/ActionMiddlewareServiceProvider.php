<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware;

use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGatewayInterface;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\RedisConnection;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\ActionMiddlewareRunnerGateway;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\ActionMiddlewareRunnerGatewayInterface;
use GuzzleHttp\Client;
use Illuminate\Redis\Connectors\PhpRedisConnector;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class ActionMiddlewareServiceProvider extends IlluminateServiceProvider
{
    /**
     * @var string
     */
    protected string $config = __DIR__.'/../config/action-middleware.php';

    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([$this->config => $this->app->configPath('action-middleware.php'),], 'action-middleware');
        }
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->config, 'action-middleware');

        $this->app->bind(ActionMiddlewareGatewayInterface::class, function () {
            /** @var \Illuminate\Contracts\Config\Repository $configRepository */
            $configRepository = $this->app->get(ConfigRepository::class);

            $config = $configRepository->get('action-middleware.redis');
            $connection = (new PhpRedisConnector())->connect($config, []);

            return new RedisConnection($connection, $configRepository->get('action-middleware.setKey'));
        });

        $this->app->singleton(ActionMiddlewareRunnerGatewayInterface::class, function () {
            return new ActionMiddlewareRunnerGateway(new Client());
        });
    }
}
