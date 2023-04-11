<?php

use LIB\View\View;

function view(string $name, $args = [], $layout = null)
{
    return new View($name, $args, $layout);
}
