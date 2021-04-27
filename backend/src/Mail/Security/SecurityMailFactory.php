<?php

declare(strict_types=1);

namespace App\Mail\Security;

use App\ConfigProvider\ConfigProvider;
use App\Entity\User\Account;
use Symfony\Component\Mime\Email;
use function str_replace;

final class SecurityMailFactory implements MailFactory
{
    public function __construct(
        private ConfigProvider $config,
    ) {}

    public function createOneTimeLoginMail(Account $account, string $link): Email
    {
        $from = $this->config->get('site.mail.noreply');
        $subject = $this->config->get('mail.security.onetime.subject');
        $body = str_replace('[:link:]', $link, $this->config->get('mail.security.onetime.body'));

        $email = new Email();
        $email->to($account->getMail())
            ->from($from)
            ->subject($subject)
            ->text($body);

        return $email;
    }
}
