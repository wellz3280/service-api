<?php

declare(strict_types=1);

namespace Infra\Http\Controller;

use Application\GetUserById\GetUserById;
use Application\GetUserById\InputModel;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class GetUserByIdController implements RequestHandlerInterface
{
    public function __construct(
        private GetUserById $usecase
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->usecase->handle(InputModel::createFromArray([
            'payload' => [
                'id' => $request->getAttribute('id'),
            ],
        ]));

        return new JsonResponse($view, 200);
    }
}
