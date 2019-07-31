<?php

namespace Swaggest\JsonCli\Tests;


use Swaggest\JsonCli\ExitCode;
use Swaggest\JsonCli\ValidateSchema;
use Yaoi\Cli\Response;

class ValidateTest extends \PHPUnit_Framework_TestCase
{
    public function testValidate()
    {
        $d = new ValidateSchema();
        $d->data = __DIR__ . '/../../tests/assets/sample-valid-data.json';
        $d->schema = __DIR__ . '/../../tests/assets/sample-schema.json';
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertContains(
            'Data is valid',
            $res
        );

    }

    public function testValidDefault()
    {
        $d = new ValidateSchema();
        $d->data = __DIR__ . '/../../tests/assets/sample-schema.json';
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $this->assertContains(
            'Data is valid',
            $res
        );

    }

    public function testInvalid()
    {
        $d = new ValidateSchema();
        $d->data = __DIR__ . '/../../tests/assets/sample-invalid-schema.json';
        $d->setResponse(new Response());
        ob_start();
        try {
            $d->performAction();
        } catch (ExitCode $e) {
            $res = ob_get_clean();
            $this->assertSame(1, $e->getCode());

            $this->assertContains(
                'Data is invalid',
                $res
            );
            return;
        }

        $this->fail('Should have returned from exception handler.');
    }

}