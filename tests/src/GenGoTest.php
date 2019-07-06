<?php

namespace Swaggest\JsonCli\Tests;

use Swaggest\JsonCli\GenGo;
use Yaoi\Cli\Response;

class GenGoTest extends \PHPUnit_Framework_TestCase
{
    public function testSwagger() {
        $d = new GenGo();
        $d->schema = __DIR__ . '/../../tests/assets/swagger-schema.json';
        $d->ptrInSchema = '#/definitions/info';
        $d->rootName = "TheInfo";
        $d->packageName = "info";

        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            file_get_contents(__DIR__ . '/../../tests/assets/go/swagger/entities.go'),
            $res
        );

    }

    public function testAsyncAPI() {
        $d = new GenGo();
        $d->schema = __DIR__ . '/../../tests/assets/asyncapi-data.yaml';
        $d->ptrInSchema = '#/components/messages/MessagingReaderReads/payload';
        $d->rootName = "MessagePayload";
        $d->packageName = "message";

        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            file_get_contents(__DIR__ . '/../../tests/assets/go/asyncapi/entities.go'),
            $res
        );

    }

}