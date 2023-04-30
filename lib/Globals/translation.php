<?php
use LIB\Translation\Translation;
function __($text,$module = null){
    return Translation::getInstance()->translate($text);
}