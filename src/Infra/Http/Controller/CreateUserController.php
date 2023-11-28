<?php

declare(strict_types=1);

namespace Infra\Http\Controller;

use Application\CreateUser\CreateUser;
use Application\CreateUser\InputModel;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class CreateUserController implements RequestHandlerInterface
{
    public function __construct(
        private CreateUser $usecase
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $payload = [
            'name'  => $request->getParsedBody()['name'],
            'email' => $request->getParsedBody()['email'],
        ];
        $view = $this->usecase->handle(InputModel::createFromArray([
            'payload' => $payload,
        ]));

        return new JsonResponse($view, 201);
    }
}
