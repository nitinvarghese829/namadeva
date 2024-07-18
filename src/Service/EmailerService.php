<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class EmailerService
{
    public function sendEmail($body, $subject): true
    {
        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);

// Create a Mailer object
        $mailer = new Mailer($transport);

// Create an Email object
        $email = (new Email());

// Set the "From address"
        $email->from('nitinemailsend@gmail.com');

// Set the "To address"
        $email->to(
            $_ENV['MAILER_USERNAME']
        # 'email2@gmail.com',
        # 'email3@gmail.com'
        );

        // Set "CC"
        # $email->cc('cc@example.com');
        // Set "BCC"
        # $email->bcc('bcc@example.com');
        // Set "Reply To"
        # $email->replyTo('fabien@example.com');
        // Set "Priority"
        # $email->priority(Email::PRIORITY_HIGH);

        // Set a "subject"
        $email->subject($subject);

        // Set the plain-text "Body"
        $email->text('The plain text version of the message.');

        // Set HTML "Body"
        $email->html($body);


        try {
            // Send email
            $mailer->send($email);

        } catch (TransportExceptionInterface $e) {
            // Display custom error message
//            die('<style>* { font-size: 100px; color: #fff; background-color: #ff4e4e; }</style><pre><h1>&#128544;Error!</h1></pre>');

            // Display real errors
//            echo '<pre style="color: red;">', print_r($e, TRUE), '</pre>';
        }
        return  true;

    }
}