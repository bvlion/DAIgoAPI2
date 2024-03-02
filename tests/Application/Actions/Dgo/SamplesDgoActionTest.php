<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Dgo;

use Tests\TestCase;

class SamplesDgoActionTest extends TestCase
{
    public function testOkGetSamples()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-samples');
        $response = $app->handle($request->withHeader('Authorization', 'Bearer test_test_test'));

        $payload = (string) $response->getBody();

        $this->assertEquals(
            json_encode(
                ['samples' => ['努力大事','負ける気がしない']],
                JSON_UNESCAPED_UNICODE
            ),
            $payload
        );
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNgHeaderNone()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-samples');
        try {
            $app->handle($request);
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 401);
        }
    }

    public function testNgHeaderWrong()
    {
        $app = $this->getAppInstance();

        $request = $this->createRequest('GET', '/get-samples');
        try {
            $app->handle($request->withHeader('Authorization', 'Bearer test2'));
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 403);
        }
    }
}
