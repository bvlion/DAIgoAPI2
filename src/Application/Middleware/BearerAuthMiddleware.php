<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;

class BearerAuthMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $authorizationHeader = $request->getHeaderLine('Authorization');
        if (empty($authorizationHeader) || !preg_match('/Bearer\s+(\S+)/', $authorizationHeader, $matches)) {
            $responseFactory = new ResponseFactory();
            $response = $responseFactory->createResponse(401);
            $response->getBody()->write('Unauthorized');
            return $response;
        }

        $token = $matches[1];

        if ($token !== $_ENV['BEARER_TOKEN']) {
            $responseFactory = new ResponseFactory();
            $response = $responseFactory->createResponse(403);
            $response->getBody()->write('Forbidden');
            return $response;
        }

        return $handler->handle($request);
    }
}
