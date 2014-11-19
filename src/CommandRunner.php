<?php

namespace RMiller\LazyBin;

use RMiller\LazyBin\Process\CachingExecutableFinder;
use RMiller\LazyBin\Process\CommandRunner\CliFunctionChecker;
use RMiller\LazyBin\Process\CommandRunner\PassthruCommandRunner;
use RMiller\LazyBin\Process\CommandRunner\PcntlCommandRunner;
use Symfony\Component\Process\PhpExecutableFinder;

class CommandRunner
{
    public function runCommand($command)
    {
        foreach ($this->getProcessRunners() as $runner) {
            if ($runner->isSupported()) {
                $runner->runCommand($this->getExecutableFinder()->getExecutablePath(), explode(' ', $command));
            }
        }
    }

    /**
     * @return CachingExecutableFinder
     */
    private function getExecutableFinder()
    {
        return new CachingExecutableFinder(new PhpExecutableFinder());
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