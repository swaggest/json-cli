<?php

namespace Swaggest\JsonDiffCli;

use Yaoi\Command;
use Yaoi\Command\Definition;

class PrettyPrint extends Command
{
    public $path;

    /**
     * @param Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Definition $definition, $options)
    {
        $options->path = Command\Option::create()->setIsUnnamed()->setIsRequired()
            ->setDescription('Path to JSON file');
        $definition->description = 'Pretty print JSON document';
    }

    public function performAction()
    {
        $json = file_get_contents($this->path);
        if (!$json) {
            $this->response->error('Unable to read ' . $this->path);
            return;
        }

        $this->response->addContent(json_encode(json_decode($json), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES));
    }

}