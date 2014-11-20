<?php

namespace RMiller\LazyBin;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class RunCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription('Run various commands')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (new CommandRunner())->runCommand($this->getFullCommandString($output));
    }

    /**
     * @throws \RuntimeException
     * @return array
     */
    private function getCommands()
    {
        $configFile = 'lazybin.yml';
        if (!is_file($configFile)) {
            throw new \RuntimeException('no lazybin.yml file found');
        }

        return $this->cleanCommands(Yaml::parse(file_get_contents($configFile))['commands']);
    }

    private function cleanCommands(array $commands)
    {
        return array_map(
            function($command) {
                return is_array($command) ? $command : ['command' => $command, 'extra' => false];
            },
            $commands
        );
    }

    /**
     * @param OutputInterface $output
     * @param $commands
     * @param $commandKey
     * @return string
     */
    private function askForExtraArguments(OutputInterface $output, $commands, $commandKey)
    {
        $extra = ' ';

        if ($commands[$commandKey]['extra']) {
            $extra .= $this->getHelper('dialog')->ask(
                $output,
                'Please provide the extra arguments: '
            );
        }

        return $extra;
    }

    /**
     * @param OutputInterface $output
     * @return string
     */
    private function getFullCommandString(OutputInterface $output)
    {
        $commands = $this->getCommands();
        $commandKey = $this->getCommandKey($output, $commands);

        return trim($commands[$commandKey]['command'] . $this->askForExtraArguments($output, $commands, $commandKey));
    }

    /**
     * @param OutputInterface $output
     * @param $commands
     * @return mixed
     */
    private function getCommandKey(OutputInterface $output, $commands)
    {
        return $this->getHelper('dialog')->select(
            $output,
            'Please select the command to run',
            array_column($commands, 'command'),
            0
        );
    }
}