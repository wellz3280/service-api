<?php

declare(strict_types=1);

namespace Infra\Http\Controller;

use Application\GetUser\GetUser;
use Application\GetUser\InputModel;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class GetUserController implements RequestHandlerInterface
{
    private GetUser $usecase;

    public function __construct(GetUser $usecase)
    {
        $this->usecase = $usecase;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var ViewModel $view */
        $view = $this->usecase->handle(InputModel::createFromArray([]));

        return new JsonResponse($view, 200);
    }
}
