<?php

namespace Swaggest\JsonCli\Tests;


use Swaggest\JsonCli\Replace;
use Yaoi\Cli\Response;

class ReplaceTest extends \PHPUnit_Framework_TestCase
{
    public function testReplace()
    {
        $d = new Replace();
        $d->path = __DIR__ . '/../../tests/assets/patch.json';
        $d->search = '"add"';
        $d->replace = '"test"';
        $d->pathFilter = "^/.*/op$";
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            '[{"value":4,"op":"test","path":"/key1/0"},{"value":5,"op":"replace","path":"/key1/0"},{"op":"remove","path":"/key2"},{"op":"remove","path":"/key3/sub0"},{"value":"a","op":"test","path":"/key3/sub1"},{"value":"c","op":"replace","path":"/key3/sub1"},{"value":"b","op":"test","path":"/key3/sub2"},{"value":false,"op":"replace","path":"/key3/sub2"},{"value":0,"op":"test","path":"/key3/sub3"},{"op":"remove","path":"/key4/1/b"},{"value":false,"op":"test","path":"/key4/1/c"},{"value":1,"op":"test","path":"/key4/2/c"},{"value":"wat","op":"test","path":"/key5"}]',
            rtrim($res)
        );
    }
}