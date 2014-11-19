<?php

namespace RMiller\LazyBin;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;

class Application extends BaseApplication
{
    protected function getCommandName(InputInterface $input)
    {
        return 'run';
    }

    protected function getDefaultCommands()
    {
        return array_merge(parent::getDefaultCommands(), [new RunCommand()]);
    }

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
} 