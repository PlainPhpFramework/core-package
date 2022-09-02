<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;

$transport = Transport::fromDsn($_ENV['MAILER_DNS']);
$mailer = new Mailer($transport);

return $mailer;

///////////////////////

use Symfony\Component\Mime\Email;
use Pelago\Emogrifier\CssInliner;

function send_mail(
    string|array $to, 
    string $subject, 
    string $message = null, 
    array $context = null, 
    string $html = null, 
    string $text = null,
    string|array $cc = null,
    string|array $bcc = null,
    string|array $replyTo = null,
    string|array $from = null,
    string|array $attach = null

) {

    static $cids = [];

    $mail = (new Email)
        ->to(...(array) $to)
        ->subject($subject);

    $cc && $mail->cc(...(array) $cc);
    $bcc && $mail->bcc(...(array) $bcc);
    $replyTo && $mail->replyTo(...(array) $replyTo);
    $from && $mail->from(...(array) $from);

    $attach && array_map([$mail, 'attachFromPath'], (array) $attach);

    $html && $mail->html($html);
    $text && $mail->text($text);

    if ($message && is_string($message)) {

        extract($context, EXTR_SKIP);
        ob_start();
        require $message;
        $message = ob_get_clean();
        $message = CssInliner::fromHtml($message)->inlineCss($css)->render();
        $base = url();
        if (preg_match_all('#(<[^>]+(?src|background)=)["\'](.*)["\']#Ui', $message, $images)) {
            foreach ($images[2] as $index => $url) {
                if (strpos($url, $base)) {

                    $cid = str_replace([$base, parse_url($url, PHP_URL_QUERY)], '', $url);
                    $path = PUB . '/' . $cid;

                    if (!isset($cids[$cid])) {
                        $cids[$cid] = true;
                        $mail->attachFromPath($path, $cid);
                    }

                    $message = str_replace(
                        $images[0][$index], 
                        $images[1][$index]."'cid:$cid'",
                        $message);
                }
            }

        }

        $mail->html($message);

    }

}