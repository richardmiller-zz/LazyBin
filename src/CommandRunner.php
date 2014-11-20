<?php

namespace RMiller\LazyBin;

use RMiller\LazyBin\Process\CommandRunner\CliFunctionChecker;
use RMiller\LazyBin\Process\CommandRunner\PassthruCommandRunner;
use RMiller\LazyBin\Process\CommandRunner\PcntlCommandRunner;

class CommandRunner
{
    public function runCommand($command)
    {
        foreach ($this->getProcessRunners() as $runner) {
            if ($runner->isSupported()) {
                $commandArgs = explode(' ', $command);
                $runner->runCommand(array_shift($commandArgs), $commandArgs);
            }
        }
    }

    private function getProcessRunners()
    {
        $functionChecker = new CliFunctionChecker($this->getExecutableFinder());

        return [
            new PassthruCommandRunner($functionChecker),
            new PcntlCommandRunner($functionChecker),
        ];
    }
} 