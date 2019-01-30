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

    public function testEmptyOutput()
    {
        $mock_process = $this->createMock(Process::class);
        $mock_process->method('getOutput')
            ->willReturn('');
        $mock_process_factory = $this->createMock(ProcessFactory::class);
        $mock_process_factory->method('getProcess')
            ->willReturn($mock_process);
        $checker = new SecurityChecker();
        $checker->setProcessFactory($mock_process_factory);
        $this->expectExceptionMessage('No output received from symfony command. This could mean you do not have the symfony command available. This is the stderr: ');
        $checker->checkDirectory('/tmp');
    }

    public function testGoodOutput()
    {
        $mock_process = $this->createMock(Process::class);
        $json_string = '[{"version": 2}]';
        $mock_process->method('getOutput')
            ->willReturn($json_string);
        $mock_process_factory = $this->createMock(ProcessFactory::class);
        $mock_process_factory->method('getProcess')
            ->willReturn($mock_process);
        $checker = new SecurityChecker();
        $checker->setProcessFactory($mock_process_factory);
        $json = $checker->checkDirectory('/tmp');
        $this->assertEquals(json_decode($json_string, true), $json);
    }

    public function testGetProcess()
    {
        // OK, this is mostly for coverage.
        $checker = new SecurityChecker();
        $factory = $checker->getProcessFactory();
        $this->assertTrue($factory instanceof ProcessFactory);
        $this->assertTrue($factory->getProcess('true') instanceof Process);
    }
}
