<?php

function env(string $param, $default = "")
{
    if (empty($_ENV[$param])) {
        return $default;
    }
    return $_ENV[$param];
}