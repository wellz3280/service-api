<?php

declare(strict_types=1);

namespace Infra\Http\Controller;

use Application\UpdateUser\InputModel;
use Application\UpdateUser\UpdateUser;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class UpdateUserController implements RequestHandlerInterface
{
    public function __construct(
        private UpdateUser $usecase
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $payalod = [
            'id'    => $request->getAttribute('id'),
            'name'  => $request->getParsedBody()['name'] ?? null,
        ];

        $view = $this->usecase->handle(InputModel::createFromArray([
            'payload' => $payalod,
        ]));

        return new JsonResponse($view, 204);
    }
}
