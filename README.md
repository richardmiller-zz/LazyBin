LazyBin
=======

Runs various commands to save me a few keystrokes.

Running various commands e.g. behat and phpspec while developing means
that the one I want is not always the last command. By configuring lazybin
to run various commands it can always be the last run command and accessed
with the up key. The configured commands can be run by digit e.g. `1`.

## Installation

This extension requires:

* PHP 5.5+

The easiest way to install it is to use Composer

```
$ composer require --dev rmiller/lazy-bin:dev-master
```

## Configuration

It needs a lazybin.yml file in the directory it is run from.

Example:

```yaml
commands:
  - "./bin/phpspec run"
  - "./bin/behat --append-snippets"
  - "./bin/behat --rerun"
  - {command:"./bin/phpspec describe", extra: true}
  - {command:"./bin/phpspec exemplify", extra: true}
```

Running `bin/lazybin` will give:

![Choice of commands](/docs/images/commands.png?raw=true)

Choosing one of the options with `extra` set to true, will ask for further arguments.
For example the `phpspec describe` command needs to be given the class being described:

![extra arguments](/docs/images/extra.png?raw=true)


## Disclaimer

This works for me on osx, no idea if it will work for anyone else.