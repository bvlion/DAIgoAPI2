<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Markdown;

use Tests\TestCase;

class TextTermsOfUseMarkdownActionTest extends TestCase
{
    public function testOkHealth()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/terms_of_use');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(
            json_encode(['text' => "<h1>【略語Generator】利用規約</h1>\n"], JSON_UNESCAPED_UNICODE),
            $payload
        );
        $this->assertEquals(200, $response->getStatusCode());
    }
}
