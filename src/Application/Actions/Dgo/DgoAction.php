<?php

declare(strict_types=1);

namespace App\Application\Actions\Dgo;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpUnauthorizedException;

abstract class DgoAction extends Action
{
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }

    protected function auth()
    {
        $authorizationHeader = $this->request->getHeaderLine('Authorization');
        if (empty($authorizationHeader) || !preg_match('/Bearer\s+(\S+)/', $authorizationHeader, $matches)) {
            $this->logger->info('authorizationHeader: ' . $authorizationHeader);
            throw new HttpUnauthorizedException($this->request);
        }

        $token = $matches[1];

        if ($token !== $_ENV['BEARER_TOKEN']) {
            throw new HttpForbiddenException($this->request);
        }
    }

    protected function contentTypeIsJson()
    {
        return true;
    }
}
