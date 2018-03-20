<?php

namespace Swaggest\JsonCli\Tests;


use Swaggest\JsonCli\ResolvePos;
use Yaoi\Cli\Response;

class ResolvePosTest extends \PHPUnit_Framework_TestCase
{
    public function testResolvePos()
    {
        $d = new ResolvePos();
        $d->path = __DIR__ . '/../../tests/assets/original.json';
        $d->pointer = '/key4/1/a';
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            "20:15\n",
            $res
        );
    }
}