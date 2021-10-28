<?php


namespace Swaggest\JsonCli\Tests;


use PHPUnit\Framework\TestCase;
use Swaggest\JsonCli\Apply;
use Swaggest\JsonCli\Diff;
use Swaggest\JsonDiff\JsonDiff;
use Yaoi\Cli\Response;

class DiffMergeTest extends TestCase
{
    public function testApply()
    {
        $d = new Apply();
        $d->pretty = true;
        $d->merge = true;
        $d->basePath = __DIR__ . '/../../tests/assets/original.json';
        $d->patchPath = __DIR__ . '/../../tests/assets/merge-patch.json';
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();

        $diff = new JsonDiff(json_decode(file_get_contents(__DIR__ . '/../../tests/assets/rearranged.json')),
            json_decode($res)
        );

        $this->assertSame(0, $diff->getDiffCnt());
    }

    public function testDiff()
    {
        $d = new Diff();
        $d->pretty = true;
        $d->rearrangeArrays = true;
        $d->merge = true;
        $d->originalPath = __DIR__ . '/../../tests/assets/original.json';
        $d->newPath = __DIR__ . '/../../tests/assets/new.json';
        $d->setResponse(new Response());
        ob_start();
        $d->performAction();
        $res = ob_get_clean();
        $this->assertSame(
            file_get_contents(__DIR__ . '/../../tests/assets/merge-patch.json'),
            str_replace("\r", '', rtrim($res))
        );
    }
}