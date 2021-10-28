<?php

namespace Swaggest\JsonCli\Tests;


use Swaggest\JsonCli\Resolve;
use Yaoi\Cli\Response;

class ResolveTest extends \PHPUnit_Framework_TestCase
{
    public function testResolve()
    {
        $d = new Resolve();
        $d->path = __DIR__ . '/../../tests/assets/original.json';
        $d->pointer = '/key4/1/a';
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            '2',
            rtrim($res)
        );
    }
}