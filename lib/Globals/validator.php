<?php
use Lib\Services\Validation\Validator;
function validator(array $data, array $rules)
{
    return new Validator($data, $rules);
}
