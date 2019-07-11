<?php

namespace Swaggest\JsonCli\Tests;

use Swaggest\JsonCli\GenGo;
use Yaoi\Cli\Response;

class GenGoTest extends \PHPUnit_Framework_TestCase
{
    public function testSwagger()
    {
        $d = new GenGo();
        $d->schema = __DIR__ . '/../../tests/assets/swagger-schema.json';
        $d->ptrInSchema = ['#/definitions/info'];
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

    public function testAsyncAPI()
    {
        $d = new GenGo();
        $d->schema = __DIR__ . '/../../tests/assets/asyncapi-schema.json';
        $d->defPtr = [
            'http://json-schema.org/draft-04/schema#/definitions',
            'http://json-schema.org/draft-04/schema',
            '#/definitions',
        ];
        $d->rootName = 'AsyncAPI';
        $d->packageName = "asyncapi";

        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            file_get_contents(__DIR__ . '/../../tests/assets/go/asyncapi/entities.go'),
            $res
        );

    }

    public function testAsyncAPIStreetLights()
    {
        $d = new GenGo();
        $d->schema = __DIR__ . '/../../tests/assets/streetlights.yml';
        $d->ptrInSchema = [
            '#/components/messages/lightMeasured/payload',
            '#/components/messages/turnOnOff/payload',
            '#/components/messages/dimLight/payload',
        ];
        $d->defPtr = ['#/components/schemas'];
        $d->packageName = "message";

        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertSame(
            file_get_contents(__DIR__ . '/../../tests/assets/go/asyncapi-streetlights/entities.go'),
            $res
        );

    }

}