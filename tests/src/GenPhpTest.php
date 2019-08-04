<?php

namespace Swaggest\JsonCli\Tests;

use Swaggest\JsonCli\ExitCode;
use Swaggest\JsonCli\GenPhp;
use Yaoi\Cli\Response;

class GenPhpTest extends \PHPUnit_Framework_TestCase
{
    public function testSwagger()
    {
        $d = new GenPhp();
        $d->schema = __DIR__ . '/../assets/swagger-schema.json';
        $d->ptrInSchema = ['#/definitions/info'];
        $d->ns = 'Swagger';
        $d->nsPath = __DIR__ . '/../assets/php/Swagger';

        $d->setResponse(new Response());
        ob_start();
        try {
            $d->performAction();
        } catch (ExitCode $exception) {
            $res = ob_end_clean();
            $this->fail($res);
            return;
        }

        ob_get_clean();

        exec('git diff ' . $d->nsPath, $out);
        $out = implode("\n", $out);
        $this->assertSame('', $out, "Generated files changed");
    }

    public function testAsyncAPI()
    {
        $d = new GenPhp();
        $d->schema = __DIR__ . '/../../tests/assets/asyncapi-schema.json';
        $d->defPtr = [
            'http://json-schema.org/draft-04/schema#/definitions',
            'http://json-schema.org/draft-04/schema',
            '#/definitions',
        ];
        $d->ns = 'AsyncAPI';
        $d->nsPath = __DIR__ . '/../assets/php/AsyncAPI';

        $d->setResponse(new Response());
        ob_start();
        try {
            $d->performAction();
        } catch (ExitCode $exception) {
            $res = ob_end_clean();
            $this->fail($res);
            return;
        }

        ob_get_clean();

        exec('git diff ' . $d->nsPath, $out);
        $out = implode("\n", $out);
        $this->assertSame('', $out, "Generated files changed");
    }

    public function testAsyncAPIStreetLights()
    {
        $d = new GenPhp();
        $d->schema = __DIR__ . '/../../tests/assets/streetlights.yml';
        $d->ptrInSchema = [
            '#/components/messages/lightMeasured/payload',
            '#/components/messages/turnOnOff/payload',
            '#/components/messages/dimLight/payload',
        ];
        $d->defPtr = ['#/components/schemas'];
        $d->ns = 'AsyncAPIStreetLight';
        $d->nsPath = __DIR__ . '/../assets/php/AsyncAPIStreetLight';

        $d->setResponse(new Response());
        ob_start();
        try {
            $d->performAction();
        } catch (ExitCode $exception) {
            $res = ob_get_clean();
            $this->fail($res);
            return;
        }

        ob_get_clean();

        exec('git diff ' . $d->nsPath, $out);
        $out = implode("\n", $out);
        $this->assertSame('', $out, "Generated files changed");
    }

}