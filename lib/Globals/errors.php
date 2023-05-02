<?php

function errors($name = null):string|array
{
    if (!$name) {
        $re = isset($_SESSION['errorsBag']) && count($_SESSION['errorsBag']) > 0 ? $_SESSION['errorsBag']: [];
        unset($_SESSION['errorsBag']);
    }else{
        $re = isset($_SESSION['errorsBag']) && isset($_SESSION['errorsBag'][$name]) ? $_SESSION['errorsBag'][$name] : '';
    }
    return $re;

}
