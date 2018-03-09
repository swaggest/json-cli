<?php

namespace Swaggest\JsonCli;

use Yaoi\Command;
use Yaoi\Command\Definition;

class App extends Command\Application
{
    public $diff;
    public $apply;
    public $rearrange;
    public $info;
    public $prettyPrint;
    public $minify;

    /**
     * @param Definition $definition
     * @param \stdClass|static $commandDefinitions
     */
    static function setUpCommands(Definition $definition, $commandDefinitions)
    {
        $definition->name = 'json-cli';
        $definition->version = 'v1.1.0';
        $definition->description = 'JSON diff and apply tool for PHP, https://github.com/swaggest/json-cli';

        $commandDefinitions->diff = Diff::definition();
        $commandDefinitions->apply = Apply::definition();
        $commandDefinitions->rearrange = Rearrange::definition();
        $commandDefinitions->info = Info::definition();
        $commandDefinitions->prettyPrint = PrettyPrint::definition();
        $commandDefinitions->minify = Minify::definition();
    }
}