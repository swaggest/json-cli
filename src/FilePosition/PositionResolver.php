<?php

namespace Swaggest\JsonCli\FilePosition;

use JsonStreamingParser\Listener;
use Swaggest\JsonDiff\JsonPointer;

class PositionResolver implements Listener
{
    /** @var string[] map of pointer to file positions */
    public $resolved;
    private $pathState;
    private $stack = [];

    public function __construct()
    {
        $this->pathState = new PathState();
        $this->pathState->path = '';
    }

    public function startDocument()
    {
    }

    public function endDocument()
    {
    }

    public function startObject()
    {
        $path = $this->pathState->path;
        if ($this->pathState->isArray) {
            $index = $this->pathState->arrayIndex++;
            $path = $this->pathState->path . '/' . $index;
            $this->resolved[$path] = $this->currentLine . ':' . $this->currentChar;
        }

        $this->stack[] = $this->pathState;
        $pathState = new PathState();
        $pathState->path = $path;
        $this->pathState = $pathState;
    }

    public function endObject()
    {
        $this->pathState = array_pop($this->stack);
        if ($this->pathState->isKey) {
            $this->pathState = array_pop($this->stack);
        }
    }


    public function startArray()
    {
        $path = $this->pathState->path;
        if ($this->pathState->isArray) {
            $index = $this->pathState->arrayIndex++;
            $path = $this->pathState->path . '/' . $index;
            $this->resolved[$path] = $this->currentLine . ':' . $this->currentChar;
        }

        $this->stack[] = $this->pathState;
        $pathState = new PathState();
        $pathState->path = $path;
        $pathState->isArray = true;
        $this->pathState = $pathState;
    }

    public function endArray()
    {
        $this->pathState = array_pop($this->stack);
        if ($this->pathState->isKey) {
            $this->pathState = array_pop($this->stack);
        }
    }

    public function key($key)
    {
        $path = $this->pathState->path . '/' . JsonPointer::escapeSegment($key);

        $this->stack[] = $this->pathState;
        $pathState = new PathState();
        $pathState->path = $path;
        $pathState->isKey = true;
        $this->pathState = $pathState;


        $this->resolved[$path] = $this->currentLine . ':' . $this->currentChar;
    }

    public function value($value)
    {
        if ($this->pathState->isArray) {
            $index = $this->pathState->arrayIndex++;
            $itemPath = $this->pathState->path . '/' . $index;
            $this->resolved[$itemPath] = $this->currentLine . ':' . $this->currentChar;
        } elseif ($this->pathState->isKey) {
            $this->pathState = array_pop($this->stack);
        }
    }

    public function whitespace($whitespace)
    {
    }

    private $currentLine;
    private $currentChar;

    /**
     * @param int $line
     * @param int $char
     */
    public function filePosition($line, $char)
    {
        $this->currentLine = $line;
        $this->currentChar = $char;
    }


}