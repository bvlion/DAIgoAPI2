<?php

declare(strict_types=1);

namespace App\Application\Actions\Dgo;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class DgoAction extends Action
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
        $this->logger = $logger;
    }
}
