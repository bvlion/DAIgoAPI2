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
            "<style>.small { font-size: 70% !important; color: red; }</style>"
            . "<div style=\"background-color: blue;\"><h1>【略語Generator】プライバシーポリシー</h1>\n</div>",
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
            "<style>.small { font-size: 70% !important; color: red; }</style>"
            . "<div style=\"background-color: blue;\"><h1>【略語Generator】利用規約</h1>\n</div>",
            $payload
        );
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Issue #67: production template (resources/rules_app.html) を直接読み込み検証する。
     * testFile/rules_app.html はAppMarkdownActionの置換処理を確認するためのfixtureであり、
     * production templateが将来 `70%%` に戻ってもfixture側が追従していなければ検知できない。
     * そのためproduction templateそのものを対象に固定する。
     */
    public function testProductionRulesAppTemplateUsesSinglePercentForFontSize()
    {
        $template = file_get_contents(dirname(__DIR__, 4) . '/resources/rules_app.html');

        $this->assertStringContainsString('font-size: 70% !important', $template);
        $this->assertStringNotContainsString('70%%', $template);
    }

    /**
     * Issue #67: rules_app.html の `font-size: 70%%` は旧DAIgoAPIのformat文字列向けescapeの名残で、
     * AppMarkdownActionはstr_replaceのみを行うためリテラルの `70%%` がそのままレスポンスへ出力されていた。
     * `70%` として出力され、`70%%` が残らないことを固定する。
     */
    public function testOkFontSizePercentIsNotDoubleEscaped()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/app/rules')->withQueryParams([
            'textColor' => '#000000',
            'backColor' => '#FFFFFF',
            'isPrivacyPolicy' => 'true',
        ]);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertStringContainsString('font-size: 70% !important', $payload);
        $this->assertStringNotContainsString('70%%', $payload);
        $this->assertStringContainsString('color: #000000;', $payload);
        $this->assertStringContainsString('background-color: #FFFFFF;', $payload);
        $this->assertStringContainsString('<h1>【略語Generator】プライバシーポリシー</h1>', $payload);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
