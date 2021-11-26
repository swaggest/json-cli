<?php

namespace Swaggest\JsonCli\Tests;


use Swaggest\JsonCli\GenJson;
use Yaoi\Cli\Response;

class GenJsonTest extends \PHPUnit_Framework_TestCase
{
    public function testGenJson()
    {
        $d = new GenJson();
        $d->schema = __DIR__ . '/../../tests/assets/sample-schema2.json';
        $d->randSeed = 100;
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            '{"foo":"abc","bar":"quux"}',
            rtrim($res)
        );
    }
}