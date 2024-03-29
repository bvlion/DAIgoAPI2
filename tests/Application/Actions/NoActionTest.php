<?php

declare(strict_types=1);

namespace Tests\Application\Actions;

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
}
