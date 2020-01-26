<?php


namespace Swaggest\JsonCli\Tests;


use PHPUnit\Framework\TestCase;
use Swaggest\JsonCli\BuildSchema;
use Yaoi\Cli\Response;

class BuildSchemaTest extends TestCase
{
    public function testuildSchema()
    {
        $d = new BuildSchema();
        $d->data = __DIR__ . '/../../tests/assets/original-minified.json';
        $d->jsonl = true;
        $d->pretty = true;
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertEquals(file_get_contents(__DIR__ . '/../assets/original-schema.json'), $res);
    }


}