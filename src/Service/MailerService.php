<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{
    
    private $mailer;
    
    
    public function __construct( MailerInterface $mailer)
     {
        
        $this->mailer=$mailer;
     }
    
    public function sendEmail(    $to,$text ): void
    {
        
        $email = (new Email())
            ->from('pfe.mailer2022@gmail.com')
            ->to($to)
            ->subject('Remise sur une vehicule')
            ->text($text);
            
             
            $this->mailer->send($email);
      
        // ...
    }
}
?>