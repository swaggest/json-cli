<?php

namespace Swaggest\JsonCli\Tests;


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

        $this->assertSame(
            'Data is valid' . "\n",
            $res
        );

    }

}