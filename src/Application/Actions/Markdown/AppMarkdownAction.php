<?php

declare(strict_types=1);

namespace App\Application\Actions\Markdown;

use Psr\Http\Message\ResponseInterface as Response;
use Michelf\Markdown;

class AppMarkdownAction extends MarkdownAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        if (
            !isset($this->request->getQueryParams()['textColor']) ||
            !isset($this->request->getQueryParams()['backColor']) ||
            !isset($this->request->getQueryParams()['isPrivacyPolicy'])
        ) {
            $this->response->getBody()->write('textColor, backColor, isPrivacyPolicy required');
            return $this->response->withStatus(400);
        }
        $textColor = $this->request->getQueryParams()['textColor'];
        $backColor = $this->request->getQueryParams()['backColor'];
        $isPrivacyPolicy = $this->request->getQueryParams()['isPrivacyPolicy'];

        $markdown = file_get_contents($_ENV['RESOURCES_DIR'] . 'terms_of_use.md');
        if ($isPrivacyPolicy === 'true') {
            $markdown = file_get_contents($_ENV['RESOURCES_DIR'] . 'privacy_policy.md');
        }
        $this->response->getBody()->write(
            str_replace(
                '%backColor%',
                $backColor,
                str_replace(
                    '%textColor%',
                    $textColor,
                    str_replace(
                        '%markdown%',
                        Markdown::defaultTransform($markdown),
                        file_get_contents($_ENV['RESOURCES_DIR'] . 'rules_app.html')
                    )
                )
            )
        );
        return $this->response->withHeader('Content-Type', 'text/html');
    }
}
