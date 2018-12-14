<?php

namespace Violinist\SymfonyCloudSecurityChecker;

use Symfony\Component\Process\Process;

class ProcessFactory
{
    public function getProcess($command)
    {
        return new Process($command);
    }
}
