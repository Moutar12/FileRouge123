<?php


namespace App\Services;


use \Swift_Mailer;
use \Swift_Message;

class ServiceEmail
{
    protected Swift_Mailer $mailer;

    /**
     * ServiceEmail constructor.
     * @param Swift_Mailer $mailer
     */
    public function __constructor(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param  $destination
     * @param $subject
     * @param $message
     */
    public function send($destination,$subject,$message)
    {
        $message = (new Swift_Message($subject))
            ->setFrom('send@example.com')
            ->setTo($destination)
            ->setBody($message);
        $this->Swift_Mailer->send($message);
        dd($message);

    }
}
