<?php
use LIB\Translation\Translation;
function __($text,array $data = []){
    return Translation::getInstance()->translate($text,$data);
}