<?php

namespace RMiller\LazyBin\Process\CommandRunner;

use RMiller\LazyBin\Process\CachingExecutableFinder;

class CliFunctionChecker
{
    /**
     * @var \Rmiller\LazyBin\Process\CachingExecutableFinder
     */
    private $executableFinder;

    /**
     * @param \Rmiller\LazyBin\Process\CachingExecutableFinder $executableFinder
     */
    public function __construct(CachingExecutableFinder $executableFinder)
    {
        $this->executableFinder = $executableFinder;
    }

    /**
     * @param string $function
     *
     * @return bool
     */
    public function functionCanBeUsed($function)
    {
        return (php_sapi_name() == 'cli')
            && $this->executableFinder->getExecutablePath()
            && function_exists($function);
    }
}
