<?php

namespace Violinist\SymfonyCloudSecurityChecker\Tests\Integration;

use Violinist\SymfonyCloudSecurityChecker\SecurityChecker;

class TestSecurityChecker extends SecurityChecker
{
    public function __construct()
    {
        $os = strtolower(PHP_OS);
        $this->symfonyCommand = __DIR__ . '/../assets/bin/symfony-' . $os;
    }
}
