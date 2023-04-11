<?php

function assets($path = ""){
    return "https://".$_SERVER['HTTP_HOST'] .$path;
}