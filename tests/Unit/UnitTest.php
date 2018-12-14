<?php

namespace Violinist\SymfonyCloudSecurityChecker\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;
use Violinist\SymfonyCloudSecurityChecker\ProcessFactory;
use Violinist\SymfonyCloudSecurityChecker\SecurityChecker;

class UnitTest extends TestCase
{
    public function testBadOutput()
    {
        $mock_process = $this->createMock(Process::class);
        $mock_process->method('getOutput')
            ->willReturn('{"json"_is_bad}');
        $mock_process_factory = $this->createMock(ProcessFactory::class);
        $mock_process_factory->method('getProcess')
            ->willReturn($mock_process);
        $checker = new SecurityChecker();
        $checker->setProcessFactory($mock_process_factory);
        $this->expectExceptionMessage('Invalid JSON found from parsing the security check data');
        $checker->checkDirectory('/tmp');
    }
}
