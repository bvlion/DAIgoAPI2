<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Markdown;

use Tests\TestCase;

class ViewPrivacyPolicyMarkdownActionTest extends TestCase
{
    public function testOkHealth()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/view/privacy_policy');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals("<div><h1>【略語Generator】プライバシーポリシー</h1>\n</div>", $payload);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
