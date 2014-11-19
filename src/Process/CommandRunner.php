<?php

namespace RMiller\LazyBin\Process;

interface CommandRunner
{
    public function runCommand($path, $args);

    public function isSupported();
}
