<?php

namespace RMiller\LazyBin\Process;

interface CommandRunner
{
    /**
     * @return void
     */
    public function runCommand($path, $args);

    /**
     * @return boolean
     */
    public function isSupported();
}
