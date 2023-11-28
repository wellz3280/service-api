<?php

declare(strict_types=1);

namespace Infra\Factories;

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\CallableResolver;
use Slim\Factory\Psr17\LaminasDiactorosPsr17Factory;
use Slim\Handlers\Strategies\RequestHandler;
use Slim\Routing\RouteCollector;
use Slim\Routing\RouteResolver;

use function sprintf;

class AppFactory
{
    public function __invoke(ContainerInterface $container): App
    {
        $requestHandle      = new RequestHandler(true);
        $responseFactoty    = LaminasDiactorosPsr17Factory::getResponseFactory();
        $callableResolver   = new CallableResolver($container);
        $routerCollector    = new RouteCollector(
            $responseFactoty,
            $callableResolver,
            $container,
            $requestHandle,
        );
        $routerResolve = new RouteResolver($routerCollector);

        $app = new App(
            $responseFactoty,
            $container,
            $callableResolver,
            $routerCollector,
            $routerResolve
        );

        $configs    = $container->get('app');
        $baseUrl    = sprintf('/%s', $configs['baseUrl']);

        (require __DIR__ . '/../../../config/routes.php')($app, $baseUrl);

        (require __DIR__ . '/../../../config/middleware.php')($app);

        return $app;
    }
}
