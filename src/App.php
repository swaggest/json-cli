<?php

namespace Swaggest\JsonDiffCli;

use Yaoi\Command;
use Yaoi\Command\Definition;

class App extends Command\Application
{
    public $diff;
    public $apply;
    public $rearrange;
    public $info;
    public $prettyPrint;

    /**
     * @param Definition $definition
     * @param \stdClass|static $commandDefinitions
     */
    static function setUpCommands(Definition $definition, $commandDefinitions)
    {
        $definition->name = 'json-diff';
        $definition->version = 'v1.0.0';
        $definition->description = 'JSON diff and apply tool for PHP, https://github.com/swaggest/json-diff-cli';

        $commandDefinitions->diff = Diff::definition();
        $commandDefinitions->apply = Apply::definition();
        $commandDefinitions->rearrange = Rearrange::definition();
        $commandDefinitions->info = Info::definition();
        $commandDefinitions->prettyPrint = PrettyPrint::definition();
    }
}