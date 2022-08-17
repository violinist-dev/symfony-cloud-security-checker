<?php

namespace Violinist\SymfonyCloudSecurityChecker;

use Symfony\Component\Process\Process;
use Violinist\ProcessFactory\ProcessFactoryInterface;

class ProcessFactory
{
    public function getProcess(array $commandline, $cwd = null, array $env = null, $input = null, $timeout = 60, array $options = null)
    {
        return new Process($commandline, $cwd, $env, $input, $timeout);
    }
}
