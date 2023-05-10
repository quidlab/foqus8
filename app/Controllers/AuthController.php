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






    public function auth()
    {
        $user = User::findByColName('user-id', request()->data()->loginID);
        if ($user && password_verify(request()->data()->password, $user->password)) {
/*             if (constant('MC_REQUIRE_EMAIL_OTP') || constant('MC_REQUIRE_PHONE_OTP')) {
                if (constant('MC_REQUIRE_PHONE_OTP')) {
                    try {
                        $this->mobileOTP($user);
                    } catch (\Throwable $th) {
                        return back()->withErrors([
                            'otp' => $th->getMessage()
                        ]);
                    }
                }
                if (constant('MC_REQUIRE_EMAIL_OTP')) {
                    $mail = new OTPMail($user->{'email'}, $user->{'user-name'});
                    try {
                        $mail->send();
                    } catch (\Throwable $th) {
                        return back()->withErrors([
                            'otp' => $th->getMessage()
                        ]);
                    }
                }

                return redirect('/auth/otp');
            } */

            $_SESSION[User::$guardKey] = $user->{'user-id'};
            $_SESSION['ROLE_ID'] = $user->{'role-id'};
            logger()->info('User logged in successfully.' . ' | login-ID:' . request()->data()->loginID .  '|  IP: ' . app()->getUserIP() . ' time:' . date('Y-m-d H:i:s'));
            redirect(Router::HOME);
            /*if (constant('MC_REQUIRE_PHONE_OTP') == false && constant('MC_REQUIRE_EMAIL_OTP') == false) { // TODO uncomment} */
        } else {
            logger()->info('User Faild to login.| login-ID:' . request()->data()->loginID . '|  IP: ' . app()->getUserIP() . '| time:' . date('Y-m-d H:i:s'));
            return back()->withErrors(['email' => 'auth-faild']);
        }
    }



    public function otpMailForm()
    {
        return view('/auth/otp');
    }

    public function otpMobileForm()
    {
        return view('/auth/mobile-otp');
    }
    /* 
    
    */
/*     public function verifyMailOTP()
    {
        $validation = validator(request()->dataArray(), [
            'otp' => ['required']
        ]);

        try {
            $data = $validation->validate();
        } catch (\Throwable $th) {
            back()->withErrors($th->errorsBag);
        }
        if (!isset($_SESSION['mail-otp'])) {
            return back()->withErrors([
                'otp' => 'Please back to login page'
            ]);
        }
        list($email, $otp) = explode(':', $_SESSION['mail-otp']);
        if ($data['otp'] == $otp) {
            $_SESSION['mail-otp-verified'] = $email;
        } else {
            return back()->withErrors([
                'otp' => __('otp-wrong-message')
            ]);
        }
    } */
    /* 
    
    */
    public function verifyOTP()
    {
        $rules = [
            ...(constant('MC_REQUIRE_PHONE_OTP')?['mobile-otp' => ['required']]:[]),
            ...(constant('MC_REQUIRE_EMAIL_OTP')?['mail-otp' => ['required']]:[]),
        ];
        $validation = validator(request()->dataArray(),$rules);

        try {
            $data = $validation->validate();
        } catch (\Throwable $th) {
            back()->withErrors($th->errorsBag);
        }


        if (!isset($_SESSION['mobile-otp'])) {
            return back()->withErrors([
                'otp' => 'Please back to login page'
            ]);
        }
        list($email, $otp) = explode(':', $_SESSION['mail-otp']);
        if ($data['otp'] == $otp) {
            $_SESSION['mobile-otp-verified'] = $email;
        } else {
            return back()->withErrors([
                'otp' => __('otp-wrong-message')
            ]);
        }
    }

    /* 
    
    */
    protected function mobileOTP(object $user)
    {
        $apiKey = constant('MC_SMS_KEY');
        $apiSecretKey = constant('MC_SMS_SECRET');

        $sms = new SMS($apiKey, $apiSecretKey);
        //$message='OTP for '.$FetchInfo['SYMBOL'] .' Expire 5 Minutes OTP: '.$otp_gen .'(REF :'.$ref_gen .')';
        $otp_gen = Hash::otp();
        $ref_gen = Hash::randString();

        $body = [
            'msisdn' => $user->mobile,
            'message' => 'OTP for ' . constant('MC_SYMBOL') . ' Expire 5 Minutes OTP: ' . $otp_gen . ' (REF :' . $ref_gen . ')',
            'sender' => 'QUIDLAB',
            'force' => 'corporate'
        ];
        $res = $sms->sendSMS($body);

        if ($res->httpStatusCode == 201) {
            $_SESSION['mobile-otp'] = $user->email . ':' . $otp_gen;
            $_SESSION['mobile-ref'] = $ref_gen;
            $OTP_Phone_Success = 'OTP Sent Successfully on Phone ending with ' . substr($user->mobile, -4);
            return redirect('/auth/mobile-otp');
        } else {
            throw new Exception('Error Sending OTP on Phone');
        }
    }

    /* 
    
    */
    public function logout()
    {
        session_destroy();
        return redirect('/admin/login');
    }
}
