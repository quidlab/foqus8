<?php

namespace App\Controllers;

use App\Models\User;
use Exception;
use Lib\Hash\Hash;
use Lib\Mail\OTPMail;
use LIB\Request\Request;
use LIB\Router\Router;
use SendGrid;
use SendGrid\Mail\Mail;
use THAIBULKSMS_API\SMS\SMS;

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



    protected function getIPAddresses()
    {
        $data = database()->Select("
            Select ipaddress From safe_ipaddresses GROUP BY ipaddress
        ");
        $ipAddresses = [];
        foreach ($data as $key => $value) {
            $ipAddresses[] = trim($value['ipaddress'], " ");
        }
        return  $ipAddresses;
    }


    public function auth()
    {
        $user = User::findByColName('user-id', request()->data()->loginID);
        if ($user && password_verify(request()->data()->password, $user->password)) {
            if (
                (constant('MC_REQUIRE_EMAIL_OTP')
                    || constant('MC_REQUIRE_PHONE_OTP'))
                && (!in_array(trim(app()->getUserIP(), " "), $this->getIPAddresses()))
            ) {

                $otp = Hash::otp();
                $ref = Hash::randString();

                if (constant('MC_REQUIRE_PHONE_OTP')) {
                    try {
                        $this->mobileOTP($user, $otp, $ref);
                    } catch (\Throwable $th) {
                        return back()->withErrors([
                            'otp' => $th->getMessage()
                        ]);
                    }
                }
                if (constant('MC_REQUIRE_EMAIL_OTP')) {

                    $mail = new OTPMail($user->{'email'}, $user->{'user-name'}, $otp, $ref);
                    try {
                        $mail->send();
                    } catch (\Throwable $th) {
                        return back()->withErrors([
                            'otp' => $th->getMessage()
                        ]);
                    }
                }

                $_SESSION['otp'] =  $otp . ":" . $_SERVER["REQUEST_TIME"];
                $_SESSION['ref'] = $ref;
                $_SESSION['verifying-email'] = $user->email;
                return redirect('/auth/otp');
            }

            $_SESSION[User::$guardKey] = $user->{'user-id'};
            $_SESSION['ROLE_ID'] = $user->{'role-id'};
            logger()->info('User logged in successfully.' . ' | login-ID:' . request()->data()->loginID .  '|  IP: ' . app()->getUserIP() . ' time:' . date('Y-m-d H:i:s'));
            redirect(Router::HOME());
        } else {
            logger()->info('User Faild to login.| login-ID:' . request()->data()->loginID . '|  IP: ' . app()->getUserIP() . '| time:' . date('Y-m-d H:i:s'));
            return back()->withErrors(['email' => 'auth-faild']);
        }
    }



    public function otpForm()
    {
        return view('/auth/otp');
    }

    /*  
    
    */
    public function verifyOTP()
    {
        $rules = [
            'otp' => ['required'],
            'verifying-email' => ['required']
        ];
        $validation = validator(request()->dataArray(), $rules);

        try {
            $data = $validation->validate();
        } catch (\Throwable $th) {
            back()->withErrors($th->errorsBag);
        }


        list($OTP, $EX_TIME) = explode(":", $_SESSION['otp']);

        if ($_SERVER["REQUEST_TIME"] - $EX_TIME > constant('MC_OTP_EXPIRATION_MINS') * 60) {
            return back()->withErrors([
                'otp' => __('time-expired-message')
            ]);
        }

        $_SESSION['otp-attempts'] = isset($_SESSION['otp-attempts']) ? (int)++$_SESSION['otp-attempts'] : 1;
        
        if ($_SESSION['otp-attempts'] > constant('MC_OTP_ATTEMPTS')) {
            unset($_SESSION['otp-attempts']);
            $request = new Request();
            $request->withErrors([
                'email' => 'you have exceeded maximum number of attempts'
            ]);
            return redirect('/admin/login');
        }

        if ($OTP != $data['otp']) {

            logger()->info('User Faild to login.| email:' . $data['verifying-email'] . '|  IP: ' . app()->getUserIP() . '| time:' . date('Y-m-d H:i:s'));
            return back()->withErrors([
                'otp' => __('wrong-otp-message')
            ]);
        }

        $user = User::findByColName('email', $data['verifying-email']);
        $_SESSION[User::$guardKey] = $user->{'user-id'};
        $_SESSION['ROLE_ID'] = $user->{'role-id'};
        logger()->info('User logged in successfully.' . ' | login-ID:' .  $data['verifying-email']  .  '|  IP: ' . app()->getUserIP() . ' time:' . date('Y-m-d H:i:s'));
        redirect(Router::HOME());
    }

    /* 
    
    */
    protected function mobileOTP(object $user, $otp, $ref)
    {
        $apiKey = constant('MC_SMS_KEY');
        $apiSecretKey = constant('MC_SMS_SECRET');
        $sms = new SMS($apiKey, $apiSecretKey);


        $body = [
            'msisdn' => $user->mobile,
            'message' => 'OTP for ' . constant('MC_SYMBOL') . ' Expire 5 Minutes OTP: ' . $otp . ' (REF :' . $ref . ')',
            'sender' => 'QUIDLAB',
            'force' => 'corporate'
        ];
        $res = $sms->sendSMS($body);

        /*         if ($res->httpStatusCode == 201 ) {
            $_SESSION['mobile-otp'] = $otp;
            $_SESSION['mobile-ref'] = $ref;
            return true;
        } else {
            throw new Exception('Error Sending OTP on Phone');
        } */
    }

    /* 
    
    */
    public function logout()
    {
        session_destroy();
        return redirect('/admin/login');
    }
}
