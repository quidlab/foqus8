<?php

namespace App\Controllers;

use LIB\Request\Request;

class AuthController extends Controller
{

    public function login()
    {
        $FoQusdatabase = $this->DB;
        $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . 'en' . "'";
        $params = array();
        $company_name = $FoQusdatabase->Select($sql, $params);

        $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
        $params = array('1');
        $languages = $FoQusdatabase->Select($sql, $params);
        $languagesHTML = '';
        foreach ($languages as $language) {
            $languagesHTML .= '<a href="?lang=' . $language['Language_ID'] . '" class="dropdown-item">';
            $languagesHTML .= '<i class="flag-icon flag-icon-' . $language['Flag_ID'] . ' mr-2"></i>' . $language['Language_Name'];
            $languagesHTML .= '</a>';
        }

        view('login', [
            'company_name' => $company_name,
            'languagesHTML' =>  $languagesHTML,
        ]);
    }






    public function auth()
    {
        $request = new Request();
        $FoQusdatabase = $this->DB;

        $sql = "SELECT * from Users where USER_ID=?  ";
        $params = array($_POST['loginID']);
        $getUser = $FoQusdatabase->Select($sql, $params);


        if (isset($_POST['submit'])) {
            //$sql="SELECT * from Users where USER_ID=? and Role_ID=? ";
            //$params = array($_POST['loginID'],'1');
            $sql = "SELECT * from Users where USER_ID=?  ";
            $params = array($_POST['loginID']);
            $getUser = $FoQusdatabase->Select($sql, $params);

            if ($getUser) {
                $hash = $getUser[0]['Password'];
                $input = $_POST['password'];
                if (MC_REQUIRE_PHONE_OTP == false && MC_REQUIRE_EMAIL_OTP == false) {
                    if (password_verify($input, $hash)) {
                        $_SESSION['uname'] = $getUser[0]['USER_ID'];
                        $_SESSION['ROLE_ID'] = $getUser[0]['Role_ID'];
                        // redirect to index page
                    } else {
                    }
                    echo "correct ";
                }
            } else {
                $request->back()->withMessage('password not correct');
            }
        }
    }



    public function logout(){
        session_destroy();
        return view('/admin/login');
    }
}
