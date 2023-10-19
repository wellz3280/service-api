<?php

declare(strict_types=1);

namespace Infra\Controller;

use DateTime;
use Laminas\Diactoros\Response\JsonResponse;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PingController implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $date = (new DateTime())->format(DATE_ATOM);

        return new JsonResponse(['data' => $date], 200);
    }
}
