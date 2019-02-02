<?php

namespace Violinist\SymfonyCloudSecurityChecker\Tests\Integration;

use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    public function testInsecure()
    {
        $checker = new TestSecurityChecker();
        $result = $checker->checkDirectory(__DIR__ . '/../assets/projects/unsecure');
        $this->assertTrue(count($result) > 0);
        $this->assertEquals('CVE-2010-4879', $result["dompdf/dompdf"]["advisories"][0]["cve"]);
    }

    public function testSecure()
    {
        $checker = new TestSecurityChecker();
        $result = $checker->checkDirectory(__DIR__ . '/../assets/projects/secure');
        $this->assertTrue(count($result) === 0);
    }
}
