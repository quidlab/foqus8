<?php

function errors($name = null)
{
    if (!$name) {
        $re = isset($_SESSION['messagesBag']) && count($_SESSION['messagesBag']) > 0 ? $_SESSION['messagesBag']: [];
    }else{
        $re = [];
    }
    unset($_SESSION['messagesBag']);
    return $re;

}
