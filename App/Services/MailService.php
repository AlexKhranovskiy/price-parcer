<?php

namespace App\Services;

class MailService
{
    private array $mailParams;

    public function __construct(array $mailParams)
    {
        $this->mailParams = $mailParams;
    }

    public function __invoke(string $emailTo, string $oldPrice, string $newPrice, string $currencyCode, string $adUrl)
    {
        $subject = 'Ad event';
        $message = 'The price of the ad ' . $adUrl . ' has changed from ' . $oldPrice . ' ' . $currencyCode . ' to ' .
            $newPrice . ' ' . $currencyCode;
        $headers = 'From: Price-watcher service <' . $this->mailParams['mailFrom'] . '>' . "\r\n" .
            'Reply-To: ' . $this->mailParams['mailFrom'] . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=utf-8' . "\r\n" .
            'Content-Transfer-Encoding: quoted-printable';

        mail($emailTo, $subject, $message, $headers);
    }
}