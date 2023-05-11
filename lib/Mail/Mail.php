<?php

namespace Lib\Mail;

use Exception;
use SendGrid\Mail\Mail as SendGridMail;
use SendGrid;

abstract class Mail
{
    protected $toName;
    protected $toEmail;


    public function __construct($toEmail, $toName = null)
    {
        $this->toEmail = $toEmail;
        $this->toName = $toName;
    }

    public function send()
    {
        $email = new SendGridMail();
        $email->setFrom(constant('MC_MAIL_FROM'), constant('MC_SYMBOL'));

        $email->setSubject($this->subject());

        $email->addTo($this->toEmail, $this->toName);
        $email->setTemplateId($this->templateID());
        $email->addDynamicTemplateDatas($this->templateData());


        $sendgrid = new SendGrid(constant('MC_SENDGRID_KEY'));
        try {
            $response = $sendgrid->send($email);
            if ($response->statusCode() >= 200 &&  $response->statusCode() < 300) {
                return $response;
            } else {
                throw new Exception("Mail Not Sent"); // MOSTAFA_TODO => throw exception
            }
        } catch (Exception $e) {
            throw $e;
        }
    }


    abstract protected function subject();
    abstract protected function templateID(): string;
    abstract protected function templateData(): array;
}
