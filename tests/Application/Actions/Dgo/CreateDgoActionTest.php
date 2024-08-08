<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Dgo;

use Tests\TestCase;

class CreateDgoActionTest extends TestCase
{
    public function testOkFromMecabOnly()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '努力大事']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'DD']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '絵文字が多い']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'EO']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '地下だと十分に涼しい']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'CJS']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '学校の校庭で座禅']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'GKZ']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '何か変な帽子']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'NHB']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '事前にパジャマを着て待つ']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'JPKM']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => 'レース会場にようこそ']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'RKY']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '綿毛であるようだ']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'W']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => 'っぽい']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => '']), $payload);
        $this->assertEquals(200, $response->getStatusCode());

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '新しい上着の色']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'AUI']), $payload);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testOkFromMecabWithNotExistsFile()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '唐揚げ食べたい']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'KT']), $payload);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testOkFromWordsFile()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => 'ポン・デ・ライオン']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'PDL']), $payload);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNgNonAllParameters()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'target is empty']), $payload);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testNgNonAllParameterValues()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-dai-go')
            ->withHeader('Authorization', 'Bearer test_test_test')
            ->withHeader('Content-Type', 'application/json')
            ->withQueryParams(['target' => '']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['text' => 'target is empty']), $payload);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testNgHeaderNone()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-dai-go');
        try {
            $app->handle($request);
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 401);
        }
    }

    public function testNgHeaderWrong()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-dai-go');
        try {
            $app->handle($request->withHeader('Authorization', 'Bearer test2'));
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 403);
        }
    }
}
