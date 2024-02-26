<?php

declare(strict_types=1);

namespace App\Application\Actions\Markdown;

use Psr\Http\Message\ResponseInterface as Response;
use Michelf\Markdown;

class ViewTermsOfUseMarkdownAction extends MarkdownAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $termsOfUse = file_get_contents($_ENV['ROOT_DIR'] . '/resources/terms_of_use.md');
        $this->response->getBody()->write(
            str_replace(
                '%title%',
                '利用規約',
                str_replace(
                    '%markdown%',
                    Markdown::defaultTransform($termsOfUse),
                    file_get_contents($_ENV['ROOT_DIR'] . '/resources/rules.html')
                )
            )
        );
        return $this->response->withHeader('Content-Type', 'text/html');
    }
}
