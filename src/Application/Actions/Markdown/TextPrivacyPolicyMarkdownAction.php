<?php

declare(strict_types=1);

namespace App\Application\Actions\Markdown;

use Psr\Http\Message\ResponseInterface as Response;
use Michelf\Markdown;

class TextPrivacyPolicyMarkdownAction extends MarkdownAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $privacyPolicy = file_get_contents($_ENV['RESOURCES_DIR'] . 'privacy_policy.md');
        $this->response->getBody()->write(
            json_encode(['text' => Markdown::defaultTransform($privacyPolicy)], JSON_UNESCAPED_UNICODE)
        );
        return $this->response->withHeader('Content-Type', 'application/json');
    }
}
