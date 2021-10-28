<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest;

use Lsv\FoodMarketIntegration\Authenticate;
use PHPUnit\Framework\TestCase;

class AuthenticateTest extends TestCase
{
    public function testTestGetter(): void
    {
        $auth = new Authenticate('user', 'server');
        self::assertSame('user', $auth->getUserAccessToken());
        self::assertSame('server', $auth->getServerAccessToken());
    }
}
