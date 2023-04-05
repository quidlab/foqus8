<?php

use LIB\Router\Router;

$_SESSION['uname'] = 'jj';

$router = new Router();

$router->get('/login', function () {
    global $FoQusdatabase;
    $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . 'en' . "'";
    $params = array();
    $company_name = $FoQusdatabase->Select($sql, $params);

    $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
    $params = array('1');
    $languages = $FoQusdatabase->Select($sql, $params);
    $languagesHTML = '';
    foreach ($languages as $language) {
        $languagesHTML .= '<a href="login.php?lang=' . $language['Language_ID'] . '" class="dropdown-item">';
        $languagesHTML .= '<i class="flag-icon flag-icon-' . $language['Flag_ID'] . ' mr-2"></i>' . $language['Language_Name'];
        $languagesHTML .= '</a>';
    }
    
    view('login', [
        'company_name' => $company_name,
        ' languagesHTML' =>  $languagesHTML,
    ]);
})->auth('uname');





$router->run();
