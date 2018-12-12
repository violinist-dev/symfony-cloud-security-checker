<?php

namespace Violinist\SymfonyCloudSecurityChecker;

use Symfony\Component\Process\Process;

class SecurityChecker
{
    protected $process;

    public function __construct()
    {

    }

    public function checkDirectory($dir)
    {
        // Start with putting a silence file in the home directory. This is because otherwise the command might want to
        // complain about updating the symfony command.
        if (getenv('HOME')) {
            $sdir = sprintf('%s/.symfony/autoupdate', getenv('HOME'));
            $command = sprintf('mkdir -p %s', $sdir);
            $process = new Process($command);
            $process->run();
            $command = sprintf('touch %s/silence', $sdir);
            $process = new Process($command);
            $process->run();
        }
        $command = sprintf('symfony security:check --dir=%s --format=json', $dir);
        $process = new Process($command);
        $process->run();
        $string = $process->getOutput();
        if (empty($string)) {
            throw new \Exception('No output received from symfony command. This could mean you do not have the symfony command available. This is the stderr: ' . $process->getErrorOutput());
        }
        if (!$json = @json_decode($string, true)) {
            throw new \Exception('Invalid JSON found from parsing the security check data');
        }
        return $json;
    }
}
