<?php

declare(strict_types=1);

namespace App\Application\Actions\Dgo;

use Psr\Http\Message\ResponseInterface as Response;

class SamplesDgoAction extends DgoAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->response->getBody()->write(
            json_encode(
                ['samples' => explode(',', file_get_contents($_ENV['RESOURCES_DIR'] . 'samples.txt'))],
                JSON_UNESCAPED_UNICODE
            )
        );
        return $this->response;
    }
}
