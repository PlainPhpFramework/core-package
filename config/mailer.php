<?php
use pp\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer as sfMailer;
use Symfony\Component\Mime\Email;


// Symfony mailer setup. 
// @See: https://symfony.com/doc/current/mailer.html

$transport = Transport::fromDsn($_ENV['MAILER_DSN']);
$mailer = new sfMailer($transport);

return new class ($mailer, $_ENV['BASE_URL'], PUB) extends Mailer
{

    // Default email message
    function newEmail(): Email
    {
        return (new Email)
            ->from('Me <me@example.com>')
            ->sender('Me <me@example.com>')
            ->replyTo('Me <me@example.com>')
            ->to('Me <me@example.com>');
    }

};