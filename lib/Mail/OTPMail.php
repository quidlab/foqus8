<?php

namespace Lib\Mail;


class OTPMail extends Mail
{

    protected $otp;
    protected $ref;
    public function __construct($toEmail, $toName = null, $otp, $ref)
    {
        $this->otp = $otp;
        $this->ref = $ref;
        parent::__construct($toEmail, $toName);
    }

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

        return [
            'otp' => $this->otp,
            'ref' => $this->ref,
        ];
    }
}
