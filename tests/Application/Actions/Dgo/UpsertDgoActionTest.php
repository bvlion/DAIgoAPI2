<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Dgo;

use Tests\TestCase;

class UpsertDgoActionTest extends TestCase
{
    public function testOkInsertDaigo()
    {
        $app = $this->getAppInstance();
        $this->assertEquals(
            "ポン・デ・ライオン=PDL\nマジムリ=MM",
            file_get_contents($_ENV['RESOURCES_DIR'] . 'words.txt')
        );

        $request = $this->createRequest('POST', '/upsert-dai-go');
        $response = $app->handle(
            $request
            ->withParsedBody(['word' => '棒々鶏', 'dai_go' => 'BBG'])
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
        );

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['save' => 'success']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(
            "ポン・デ・ライオン=PDL\nマジムリ=MM\n棒々鶏=BBG",
            file_get_contents($_ENV['RESOURCES_DIR'] . 'words.txt')
        );

        file_put_contents(
            $_ENV['RESOURCES_DIR'] . 'words.txt',
            "ポン・デ・ライオン=PDL\nマジムリ=MM"
        );
    }

    public function testOkUpdateDaigo()
    {
        $app = $this->getAppInstance();
        $this->assertEquals(
            "ポン・デ・ライオン=PDL\nマジムリ=MM",
            file_get_contents($_ENV['RESOURCES_DIR'] . 'words.txt')
        );

        $request = $this->createRequest('POST', '/upsert-dai-go');
        $response = $app->handle(
            $request
            ->withParsedBody(['word' => 'ポン・デ・ライオン', 'dai_go' => 'PDLN'])
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
        );

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['save' => 'success']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(
            "ポン・デ・ライオン=PDLN\nマジムリ=MM",
            file_get_contents($_ENV['RESOURCES_DIR'] . 'words.txt')
        );

        file_put_contents(
            $_ENV['RESOURCES_DIR'] . 'words.txt',
            "ポン・デ・ライオン=PDL\nマジムリ=MM"
        );
    }

    public function testNgNoParameter()
    {
        $app = $this->getAppInstance();
        $this->assertEquals(
            "ポン・デ・ライオン=PDL\nマジムリ=MM",
            file_get_contents($_ENV['RESOURCES_DIR'] . 'words.txt')
        );

        $request = $this->createRequest('POST', '/upsert-dai-go');
        $response = $app->handle(
            $request
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
        );

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['save' => 'parameter is empty']), $payload);
        $this->assertEquals(400, $response->getStatusCode());

        $this->assertEquals(
            "ポン・デ・ライオン=PDL\nマジムリ=MM",
            file_get_contents($_ENV['RESOURCES_DIR'] . 'words.txt')
        );
    }

    public function testNgEmptyParameter()
    {
        $app = $this->getAppInstance();
        $this->assertEquals(
            "ポン・デ・ライオン=PDL\nマジムリ=MM",
            file_get_contents($_ENV['RESOURCES_DIR'] . 'words.txt')
        );

        $request = $this->createRequest('POST', '/upsert-dai-go');
        $response = $app->handle(
            $request
            ->withParsedBody(['word' => '', 'dai_go' => ''])
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
        );

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['save' => 'parameter is empty']), $payload);
        $this->assertEquals(400, $response->getStatusCode());

        $this->assertEquals(
            "ポン・デ・ライオン=PDL\nマジムリ=MM",
            file_get_contents($_ENV['RESOURCES_DIR'] . 'words.txt')
        );
    }

    public function testNgHeaderNone()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('POST', '/upsert-dai-go');
        try {
            $app->handle($request);
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 401);
        }
    }

    public function testNgHeaderWrong()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('POST', '/upsert-dai-go');
        try {
            $app->handle($request->withHeader('Authorization', 'Bearer test2'));
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 403);
        }
    }
}
