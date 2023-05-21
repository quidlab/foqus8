<?
$sql = 'select ID,Constant_Name,Constant_Value,Description from Meeting_Constants_Str';
$meeting_constants = $FoQusdatabase->Select($sql, []);
foreach ($meeting_constants as $meeting_constant) {
    define('MC_' . $meeting_constant['Constant_Name'], $meeting_constant['Constant_Value']);
}


$sql = 'select ID,Constant_Name,Constant_Value,Description from Meeting_Constants_Bool';
$meeting_constants = $FoQusdatabase->Select($sql, []);
foreach ($meeting_constants as $meeting_constant) {
    define('MC_' . $meeting_constant['Constant_Name'], $meeting_constant['Constant_Value']);
}


$sql = 'select ID,Constant_Name,Constant_Value,Description from Meeting_Constants_Number';
$meeting_constants = $FoQusdatabase->Select($sql, []);
foreach ($meeting_constants as $meeting_constant) {
    define('MC_' . $meeting_constant['Constant_Name'], $meeting_constant['Constant_Value']);
}

/* print_r(get_defined_constants());die; */