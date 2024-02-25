<?php

declare(strict_types=1);

namespace App\Application\Actions\Markdown;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class MarkdownAction extends Action
{

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }
}
