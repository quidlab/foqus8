<?php

function assets($path = ""){
    return "http://".$_SERVER['HTTP_HOST'] .$path;
}