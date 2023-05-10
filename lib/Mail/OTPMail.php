<?php

namespace Lib\Mail;

use Lib\Hash\Hash;

class OTPMail extends Mail
{

    protected function subject(): string
    {
        return __('otp-mail-subject');
    }

    protected function templateID(): string
    {
        return 'd-58ac95004a8f4fa68058e9fdb7174a93';
    }


    protected function templateData(): array
    {
        $otp = Hash::otp();
        $ref = Hash::randString();
        $_SESSION['mail-otp'] = $this->toEmail . ':' . $otp;
        $_SESSION['mail-ref'] = $ref;

        return [
            'otp' => $otp,
            'ref' => $ref,
        ];
    }
}
