<?php

namespace Swaggest\JsonCli\Tests;

use Swaggest\JsonCli\App;
use Swaggest\JsonCli\GenJSDoc;
use Swaggest\JsonCli\GenMarkdown;
use Yaoi\Cli\Response;

class GenMarkdownTest extends \PHPUnit_Framework_TestCase
{
    public function testSwagger()
    {
        $d = new GenMarkdown();
        $d->schema = __DIR__ . '/../../tests/assets/swagger-schema.json';
        $d->ptrInSchema = ['#/definitions/info'];

        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

//        file_put_contents(__DIR__ . '/../../tests/assets/markdown/swagger/entities.md', $res);

        $this->assertSame(
            str_replace('<version>', App::$ver,
                file_get_contents(__DIR__ . '/../../tests/assets/markdown/swagger/entities.md')),
            $res
        );

    }

    public function testAsyncAPI()
    {
        $d = new GenMarkdown();
        $d->schema = __DIR__ . '/../../tests/assets/asyncapi-schema.json';
        $d->defPtr = [
            'http://json-schema.org/draft-04/schema#/definitions',
            'http://json-schema.org/draft-04/schema',
            '#/definitions',
        ];

        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

//        file_put_contents(__DIR__ . '/../../tests/assets/markdown/asyncapi/entities.md', $res);

        $this->assertSame(
            str_replace('<version>', App::$ver,
                file_get_contents(__DIR__ . '/../../tests/assets/markdown/asyncapi/entities.md')),
            $res
        );

    }

    public function testAsyncAPIStreetLights()
    {
        $d = new GenMarkdown();
        $d->schema = __DIR__ . '/../../tests/assets/streetlights.yml';
        $d->ptrInSchema = [
            '#/components/messages/lightMeasured/payload',
            '#/components/messages/turnOnOff/payload',
            '#/components/messages/dimLight/payload',
        ];
        $d->defPtr = ['#/components/schemas'];
        $d->patches = [
            __DIR__ . '/../assets/streetlights-patch.json',
            __DIR__ . '/../assets/streetlights-merge-patch.json',
        ];

        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

//        file_put_contents(__DIR__ . '/../../tests/assets/markdown/asyncapi-streetlights/entities.md', $res);

        $this->assertSame(
            str_replace('<version>', App::$ver,
                file_get_contents(__DIR__ . '/../../tests/assets/markdown/asyncapi-streetlights/entities.md')),
            $res
        );

    }

}