<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use Tests\TestCase;

class NoActionTest extends TestCase
{
    public function testOkHealth()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/health');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['status' => 'ok']), $payload);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testOkGetSamples()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-samples');
        $response = $app->handle($request->withHeader('Authorization', 'Bearer test_test_test'));

        $payload = (string) $response->getBody();

        $this->assertEquals(json_encode(['努力大事','負ける気がしない'], JSON_UNESCAPED_UNICODE), $payload);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNgHeaderNoneGetSamples()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-samples');
        $response = $app->handle($request);

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testNgHeaderWrongGetSamples()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-samples');
        $response = $app->handle($request->withHeader('Authorization', 'Bearer test2'));

        $this->assertEquals(403, $response->getStatusCode());
    }
}
