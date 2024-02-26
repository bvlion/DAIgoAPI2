<?php

declare(strict_types=1);

namespace App\Application\Actions\Markdown;

use Psr\Http\Message\ResponseInterface as Response;
use Michelf\Markdown;

class TextTermsOfUseMarkdownAction extends MarkdownAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $termsOfUse = file_get_contents($_ENV['RESOURCES_DIR'] . 'terms_of_use.md');
        $this->response->getBody()->write(
            json_encode(['text' => Markdown::defaultTransform($termsOfUse)], JSON_UNESCAPED_UNICODE)
        );
        return $this->response->withHeader('Content-Type', 'application/json');
    }
}
