<?php

namespace Swaggest\JsonCli\Tests;


use Swaggest\JsonCli\Minify;
use Yaoi\Cli\Response;

class MinifyTest extends \PHPUnit_Framework_TestCase
{
    public function testMinify()
    {
        $d = new Minify();
        $d->path = __DIR__ . '/../../tests/assets/original.json';
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            file_get_contents(__DIR__ . '/../../tests/assets/original-minified.json'),
            rtrim($res)
        );
    }
}