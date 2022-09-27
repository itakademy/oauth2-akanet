<?php

namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Provider\AkanetResourceOwner;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class AkanetResourceOwnerTest extends TestCase
{
    public function testUrlIsNullWithoutDomainOrNickname(): void
    {
        $user = new AkanetResourceOwner();

        $url = $user->getUrl();

        $this->assertNull($url);
    }

    public function testUrlIsDomainWithoutNickname(): void
    {
        $domain = uniqid();
        $user = new AkanetResourceOwner();
        $user->setDomain($domain);

        $url = $user->getUrl();

        $this->assertEquals($domain, $url);
    }

    public function testUrlIsNicknameWithoutDomain(): void
    {
        $nickname = uniqid();
        $user = new AkanetResourceOwner(['login' => $nickname]);

        $url = $user->getUrl();

        $this->assertEquals($nickname, $url);
    }
}
