<?php

declare(strict_types=1);

namespace Infra\Http\Controller;

use DateTime;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use const DATE_ATOM;

final class PingController implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $date = (new DateTime())->format(DATE_ATOM);

        return new JsonResponse(['data' => $date], 200);
    }
}
