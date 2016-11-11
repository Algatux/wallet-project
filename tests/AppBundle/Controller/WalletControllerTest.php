<?php

declare(strict_types = 1);

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\AppTestCase;

class WalletControllerTest extends AppTestCase
{
    /**
     * @dataProvider routesProvider
     */
    public function testRoute(string $route)
    {
        $this->markTestSkipped('not ready, fixtures needed');

        $client = static::createClient();

        $client->request('GET', $route);

        self::assertTrue($client->getResponse()->isOk());
    }

    public function routesProvider()
    {
        return [
            ['/list'],
            ['/create'],
            ['/modify'],
            ['/delete'],
            ['/'],
        ];
    }

}
