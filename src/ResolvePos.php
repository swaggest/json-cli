<?php

namespace Swaggest\JsonCli;


use Swaggest\JsonDiff\Exception;
use Swaggest\JsonDiff\JsonPointer;
use Yaoi\Command;
use Yaoi\Command\Definition;
use Yaoi\Io\Content\Rows;

class ResolvePos extends Command
{
    public $path;
    public $pointer;
    public $dumpAll;

    /**
     * @param Definition $definition
     * @param \stdClass|static $options
     */
    static function setUpDefinition(Definition $definition, $options)
    {
        $options->path = Command\Option::create()->setType()->setIsUnnamed()
            ->setDescription('Path to JSON file');
        $options->pointer = Command\Option::create()->setType()->setIsUnnamed()
            ->setDescription('JSON Pointer, example /key4/1/a');
        $options->dumpAll = Command\Option::create()->setDescription('Dump all pointer positions from JSON');
    }

    public function performAction()
    {
        $listener = new FilePosition\PositionResolver();
        $stream = fopen($this->path, 'r');
        try {
            $parser = new \JsonStreamingParser\Parser($stream, $listener);
            $parser->parse();
            fclose($stream);
        } catch (\Exception $e) {
            fclose($stream);
            $this->response->error($e->getMessage());
            die(1);
        }

        if ($this->dumpAll) {
            $rows = array();
            foreach ($listener->resolved as $pointer => $pos) {
                $rows[] = array(
                    'Pos' => $pos,
                    'Ptr' => $pointer,
                );
            }
            $this->response->addContent(new Rows(new \ArrayIterator($rows)));
        } else {
            try {
                // Convert to non-URI pointer
                $pointer = JsonPointer::buildPath(JsonPointer::splitPath($this->pointer));
            } catch (Exception $e) {
                $this->response->error($e->getMessage());
                die(1);
            }

            if (isset($listener->resolved[$pointer])) {
                $this->response->addContent($listener->resolved[$pointer]);
            } else {
                $this->response->error('Pointer not found');
                die(1);
            }
        }


    }


}