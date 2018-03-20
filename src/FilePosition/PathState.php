<?php

namespace Swaggest\JsonCli\FilePosition;


class PathState
{
    public $path;
    public $isArray = false;
    public $isKey = false;
    public $arrayIndex = 0;
}