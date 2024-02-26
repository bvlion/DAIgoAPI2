<?php

declare(strict_types=1);

namespace App\Application\Actions\Markdown;

use Psr\Http\Message\ResponseInterface as Response;
use Michelf\Markdown;

class ViewPrivacyPolicyMarkdownAction extends MarkdownAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $privacyPolicy = file_get_contents($_ENV['ROOT_DIR'] . '/resources/privacy_policy.md');
        $this->response->getBody()->write(
            str_replace(
                '%title%',
                'プライバシーポリシー',
                str_replace(
                    '%markdown%',
                    Markdown::defaultTransform($privacyPolicy),
                    file_get_contents($_ENV['ROOT_DIR'] . '/resources/rules.html')
                )
            )
        );
        return $this->response->withHeader('Content-Type', 'text/html');
    }
}
