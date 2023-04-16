<?php
use LIB\Translation\Translation;
function __($text){
    return Translation::getInstance()->translate($text);
}