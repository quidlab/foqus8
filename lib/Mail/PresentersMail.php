<?php

namespace Lib\Mail;


class PresentersMail extends Mail
{

    protected $data;
    public function __construct($toEmail, $toName = null, $data = [])
    {
        $this->data = $data;
        parent::__construct($toEmail, $toName);
    }

    protected function subject(): string
    {
        return __('otp-mail-subject');
    }

    protected function templateID(): string
    {
        return constant('MC_SHAREHOLDER_EMAIL_TEMPLATE_ID');
    }


    protected function templateData(): array
    {

        return $this->data;
    }
}
