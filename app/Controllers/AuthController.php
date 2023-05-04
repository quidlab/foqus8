<?php

namespace App\Controllers;

use App\Models\User;
use LIB\Request\Request;
use LIB\Router\Router;

class AuthController extends Controller
{

    public function login()
    {
        $FoQusdatabase = $this->DB;
        $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . $this->app->local . "'";
        $params = array();
        $company_name = $FoQusdatabase->Select($sql, $params);

        $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
        $params = array('1');
        $languages = $FoQusdatabase->Select($sql, $params) ?? [];
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

        if ($user = User::attemptByUserId(request()->data()->loginID, request()->data()->password)) { // TODO => the password should match password complexity exists in Constants Table
            logger()->info('User logged in successfully.' . ' | login-ID:' . request()->data()->loginID .  '|  IP: ' . app()->getUserIP() . ' time:' . date('Y-m-d H:i:s'));
            redirect(Router::HOME);
            /*if (constant('MC_REQUIRE_PHONE_OTP') == false && constant('MC_REQUIRE_EMAIL_OTP') == false) { // TODO uncomment} */
        } else {
            logger()->info('User Faild to login.| login-ID:' . request()->data()->loginID . '|  IP: ' . app()->getUserIP() . '| time:' . date('Y-m-d H:i:s'));
            return back()->withErrors(['email' => 'auth-faild']);
        }
    }


    public function logout()
    {
        session_destroy();
        return redirect('/admin/login');
    }
}
