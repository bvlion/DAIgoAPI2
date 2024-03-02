<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Markdown;

use Tests\TestCase;

class AppMarkdownActionTest extends TestCase
{
    public function testNgNonAllParameters()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/app/rules');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals('textColor, backColor, isPrivacyPolicy required', $payload);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testNgNonTextColor()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/app/rules')->withQueryParams([
            'backColor' => 'blue',
            'isPrivacyPolicy' => 'true',
        ]);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals('textColor, backColor, isPrivacyPolicy required', $payload);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testNgNonBackColor()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/app/rules')->withQueryParams([
            'textColor' => 'red',
            'isPrivacyPolicy' => 'true',
        ]);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals('textColor, backColor, isPrivacyPolicy required', $payload);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testNgNonIsPrivacyPolicy()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/app/rules')->withQueryParams([
            'textColor' => 'red',
            'backColor' => 'blue',
        ]);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals('textColor, backColor, isPrivacyPolicy required', $payload);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testOkPrivacyPolicy()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/app/rules')->withQueryParams([
            'textColor' => 'red',
            'backColor' => 'blue',
            'isPrivacyPolicy' => 'true',
        ]);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(
            "<div style=\"color: red; background-color: blue;\"><h1>【略語Generator】プライバシーポリシー</h1>\n</div>",
            $payload
        );
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testOkTermsOfUse()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/app/rules')->withQueryParams([
            'textColor' => 'red',
            'backColor' => 'blue',
            'isPrivacyPolicy' => 'false',
        ]);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(
            "<div style=\"color: red; background-color: blue;\"><h1>【略語Generator】利用規約</h1>\n</div>",
            $payload
        );
        $this->assertEquals(200, $response->getStatusCode());
    }
}
