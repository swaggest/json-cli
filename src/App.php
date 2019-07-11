<?php

namespace Swaggest\JsonCli;

use Yaoi\Command;
use Yaoi\Command\Definition;

class App extends Command\Application
{
    public $diff;
    public $apply;
    public $rearrange;
    public $diffInfo;
    public $prettyPrint;
    public $minify;
    public $replace;
    public $resolve;
    public $resolvePos;
    public $validateSchema;

    /**
     * @param Definition $definition
     * @param \stdClass|static $commandDefinitions
     */
    static function setUpCommands(Definition $definition, $commandDefinitions)
    {
        $definition->name = 'json-cli';
        $definition->version = 'v1.5.0';
        $definition->description = 'JSON CLI tool, https://github.com/swaggest/json-cli';

        $commandDefinitions->diff = Diff::definition();
        $commandDefinitions->apply = Apply::definition();
        $commandDefinitions->rearrange = Rearrange::definition();
        $commandDefinitions->diffInfo = DiffInfo::definition();
        $commandDefinitions->prettyPrint = PrettyPrint::definition();
        $commandDefinitions->minify = Minify::definition();
        $commandDefinitions->replace = Replace::definition();
        $commandDefinitions->resolve = Resolve::definition();
        $commandDefinitions->resolvePos = ResolvePos::definition();
        $commandDefinitions->validateSchema = ValidateSchema::definition();
        $commandDefinitions->genGo = GenGo::definition();
    }
}