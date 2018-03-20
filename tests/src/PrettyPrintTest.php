<?php

namespace Swaggest\JsonCli\Tests;


use Swaggest\JsonCli\PrettyPrint;
use Yaoi\Cli\Response;

class PrettyPrintTest extends \PHPUnit_Framework_TestCase
{
    public function testPrettyPrint()
    {
        $d = new PrettyPrint();
        $d->path = __DIR__ . '/../../tests/assets/original-minified.json';
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            file_get_contents(__DIR__ . '/../../tests/assets/original.json'),
            $res
        );

    }
}