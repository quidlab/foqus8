<?php

function successes($name = null):string|array
{
    if (!$name) {
        $re = isset($_SESSION['successBag']) && count($_SESSION['successBag']) > 0 ? $_SESSION['successBag']: [];
        unset($_SESSION['successBag']);
    }else{
        $re = isset($_SESSION['successBag']) && isset($_SESSION['successBag'][$name]) ? $_SESSION['successBag'][$name] : '';
    }
    return $re;
}
