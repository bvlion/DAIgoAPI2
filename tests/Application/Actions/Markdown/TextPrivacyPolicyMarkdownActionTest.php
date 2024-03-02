<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Markdown;

use Tests\TestCase;

class TextPrivacyPolicyMarkdownActionTest extends TestCase
{
    public function testOkHealth()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/privacy_policy');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(
            json_encode(['text' => "<h1>【略語Generator】プライバシーポリシー</h1>\n"], JSON_UNESCAPED_UNICODE),
            $payload
        );
        $this->assertEquals(200, $response->getStatusCode());
    }
}
